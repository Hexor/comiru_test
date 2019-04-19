<?php


namespace App\Http\Controllers\traits;

use Exception;
use App\LineUser;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

trait CommonAuthTrait
{
    /**
     * 当用户已经登录了一个帐号A, 想要绑定B帐号时, 首先验证B帐号的合法性
     * @param $request
     * @param $lineID
     * @param $signType
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function verifyAuthInfoBeforeBind($request, $lineID, $signType)
    {
        if ($request->is_signup) {
            if ($signType === 'teacher') {
                $exist = LineUser::where('id', $lineID)->whereNotNull('teacher_id')->first();
                if ($exist) {
                    throw new Exception('一个Line 帐号只能绑定一个教师帐号, 注册失败', Response::HTTP_CONFLICT);
                }
            }
            $proxy = Request::create('/api/auth/signup', 'POST', $request->all());
        } else {
            $proxy = Request::create('/api/auth/signin', 'POST', $request->all());
        }

        return app()->handle($proxy);
    }

    public function commonSwitchUser($request, $lineUserRepository, $userRepository, $lineUser)
    {
        $targetUser = $userRepository->getUserByID($request->id, $request->sign_type);
        $targetLineUser = $lineUserRepository->findByUser($targetUser);

        if (!$targetLineUser || !$lineUser) {
            return responseUnauthorized();
        }

        if ($targetLineUser->getOriginal()['id'] !== $lineUser->getOriginal()['id']) {
            return responseUnauthorized();
        }

        $personalAccessTokenResult = $targetUser->createToken($request->sign_type . 'token');
        return responseSuccess([
            'access_token' => $personalAccessTokenResult->accessToken,
            'expires_in' => env('TOKEN_EXPIRE_SECONDS'),
            'sign_type' => $targetUser->sign_type
        ]);
    }
}
