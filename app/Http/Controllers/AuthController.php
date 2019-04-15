<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function bindLine(Request $request)
    {
        $tokenProvider = $request->token_provider;
        $decoded = JWT::decode($request->line_token, env('LINE_CLIENT_SECRET'), ['HS256']);

        // TODO 开始绑定逻辑
        $lineUser = new LineUserRepository();
        $lineUser->create($decoded, $tokenProvider, $request->user());
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
        $jwt = $http->post('https://api.line.me/oauth2/v2.1/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => env('LINE_CLIENT_ID'),
                'client_secret' => env('LINE_CLIENT_SECRET'),
                'redirect_uri' => 'http://127.0.0.1:8000/api/line_auth_callback',
                'code' => $request->code,
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);


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
//        return redirect("http://localhost:8080/#/auth/line?access_token={$accessToken}&expires_in={$expiresIn}");


        $decoded = JWT::decode($encodedDataFromLineServer['id_token'], env('LINE_CLIENT_SECRET'), ['HS256']);
//   解密 id_token 后得到用户的 line信息
//    +"iss": "https://access.line.me"  make sure
//    +"sub": "U57f93ee27d38ec9077cedb50059ef4c2" User ID for which the ID token is generated
//    +"aud": "1564192144" make sure it is your channel id
//    +"exp": 1555057940 make sure current time is not larger than exp (1小时过期)
//    +"iat": 1555054340 Time when the ID token was generated in UNIX time.
        // TODO 创建一条记录在 Line_user 表里
        dd($decoded);
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:10',
            'password' => 'required|min:6|max:20',
            'signup_type' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != 'teacher' && $value != 'student') {
                        return $fail('必须选择要注册的用户类型');
                    }
                },
            ]
        ]);

        $proxy = Request::create('/oauth/token', 'POST', [
            'username' => $request->username,
            'password' => $request->password,
            'grant_type' => 'password',
            'provider' => $this->getTokenProvider($request),
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'scope' => '*'
        ]);
        return app()->handle($proxy);
    }

    public function signup(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:10',
            'password' => 'required|min:6|max:20',
            'nickname' => 'required|max:20',
            'signup_type' => [
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
        if ($request->signup_type === 'teacher') {
            $user = new Teacher($userInfo);
        } else {
            $user = new Student($userInfo);
        }

        $saved = $user->save();
        if (!$saved) {
            // TODO throw error
        }
        $proxy = Request::create('/api/auth/signin', 'POST', [
            'username' => $request->username,
            'password' => $request->password,
            'provider' => $this->getTokenProvider($request)
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

    private function getTokenProvider($request)
    {
        $tokenProvider = "";
        if ($request->signup_type === 'teacher') {
            $tokenProvider = 'teachers';
        } elseif ($request->signup_type === 'student') {
            $tokenProvider = 'students';
        }

        return $tokenProvider;

    }
}