<?php

namespace App\Http\Controllers;

use Exception;
use App\Student;
use App\Teacher;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Repositories\LineUserRepository;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function push()
    {
    }

    /**
     * 处理由 Line 服务器上发来的请求
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function lineAuthCallback(Request $request)
    {
        if ($request->state != '12345') {
            return 'error 1';
        }

        $http = new Client();
        $postContent = [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => env('LINE_CLIENT_ID'),
                'client_secret' => env('LINE_CLIENT_SECRET'),
                'redirect_uri' => config('app.url'). '/api/line_auth_callback',
                'code' => $request->code,
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ];

        // 开发环境 Line API 服务器被墙, 使用代理
        if (env('APP_URL') == 'http://comiru.tt') {
            $postContent['curl'] = [
                CURLOPT_PROXY => '127.0.0.1:12333',
                CURLOPT_SSL_VERIFYPEER => false,
            ];
        }

        $jwt = $http->post('https://api.line.me/oauth2/v2.1/token', $postContent);


        // line 返回的加密后的用户信息
        //  "access_token" => "eyJhb......"
        //  "token_type" => "Bearer"
        //  "refresh_token" => "GR87P4JaLfKqJcXSMgID...."
        //  "expires_in" => 2592000
        //  "scope" => "openid"
        //  "id_token" => "eyJ0eXAiOiJKcyCI"

        $encodedDataFromLineServer = json_decode($jwt->getBody()->getContents(), true);
//        dd($encodedDataFromLineServer);

        $accessToken = $encodedDataFromLineServer['id_token'];
        $expiresIn = $encodedDataFromLineServer['expires_in'];

        return redirect(config('app.url') . "/#/auth/line?access_token={$accessToken}&expires_in={$expiresIn}");

//        $decoded = JWT::decode($encodedDataFromLineServer['id_token'], env('LINE_CLIENT_SECRET'), ['HS256']);
        //   解密 id_token 后得到用户的 line信息
//    +"iss": "https://access.line.me"  make sure
//    +"sub": "U57f93ee27d38ec9077cedb50059ef4c2" User ID for which the ID token is generated
//    +"aud": "1564192144" make sure it is your channel id
//    +"exp": 1555057940 make sure current time is not larger than exp (1小时过期)
//    +"iat": 1555054340 Time when the ID token was generated in UNIX time.
//        dd($decoded);
    }

    /**
     * 用户使用帐号密码登录
     * @param Request $request
     * @param LineUserRepository $lineUserRepository
     * @return \Illuminate\Http\JsonResponse|Response
     * @throws Exception
     */
    public function signin(Request $request, LineUserRepository $lineUserRepository)
    {
        $this->validate($request, [
            'username' => 'required|max:10',
            'password' => 'required|min:6|max:20',
            'sign_type' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != 'teacher' && $value != 'student') {
                        return $fail('必须选择要登录的用户类型');
                    }
                },
            ]
        ]);

        $signType = $request->sign_type;
        $proxy = Request::create('/oauth/token', 'POST', [
            'username' => $request->username,
            'password' => $request->password,
            'grant_type' => 'password',
            'provider' => getTokenProvider($request),
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'scope' => '*'
        ]);

        $response = app()->handle($proxy);
        if (!$response->isOk()) {
            return responseUnauthorized('帐号或密码错误, 登录失败');
        }

        // 登录成功后, 检测该用户是否绑定过line, 并将状态传回客户端
        if ($lineUserRepository->isUserBindLine($request->username, $signType)) {
            $responseArray = json_decode($response->getContent(), true);
            $responseArray['line_exist_in_server'] = 'line_exist_in_server';
            $response->setContent(
                json_encode($responseArray)



            );
        }

        return $response;
    }

    /**
     * 用户使用帐号密码注册
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function signup(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:10',
            'password' => 'required|min:6|max:20',
            'nickname' => 'required|max:20',
            'sign_type' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != 'teacher' && $value != 'student') {
                        return $fail('必须选择要注册的用户类型');
                    }
                },
            ]
        ]);
        $this->validate($request, [
            'username' => 'unique:students',
        ]);
        $this->validate($request, [
            'username' => 'unique:teachers',
        ]);

        $userInfo = [
            'nickname' => $request->nickname,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ];
        if ($request->sign_type === 'teacher') {
            $user = new Teacher($userInfo);
        } else {
            $user = new Student($userInfo);
        }

        $saved = $user->save();
        if (!$saved) {
            throwSaveFailedException('无法存储数据, 注册失败');
        }
        $proxy = Request::create('/api/auth/signin', 'POST', [
            'username' => $request->username,
            'password' => $request->password,
            'sign_type' => $request->sign_type
        ]);

        return app()->handle($proxy);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
