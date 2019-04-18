<?php

namespace App\Http\Controllers;

use App\Http\Controllers\traits\commonAuthTrait;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Repositories\LineUserRepository;
use Exception;
use Firebase\JWT\JWT;

class UserController extends Controller
{
    use commonAuthTrait;

    /**
     * 用户曾经绑定过 line, 但是没有持有 Line token, 并且希望绑定更多帐号时使用
     * @param Request $request
     * @param LineUserRepository $lineUserRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function bindUser(Request $request, LineUserRepository $lineUserRepository, UserRepository $userRepository)
    {
        $signType = $request->sign_type;
        $currentUser = $request->user();
        $tokenProvider = getTokenProvider($request);

        $lineUser = $lineUserRepository->isUserBindLine($currentUser->username, $currentUser->sign_type);
        if (!$lineUser) {
            return responseUnauthorized('当前帐号没有绑定过 Line, 绑定新帐号失败');
        }

        $response = $this->verifyAuthInfoBeforeBind($request, $lineUser->getOriginal()['id'], $signType);
        if (!$response->isOk()) {
            return $response;
        }

        $target = $lineUserRepository->isUserBindLine($request->username, $signType);
        if ($target) {
            if ($target->getOriginal()['id'] != $lineUser->getOriginal()['id']) {
                throw new Exception('该帐号已经绑定的 Line 帐号不属于你, 绑定新帐号失败');
            }
        }

        $lineUserRepository->create(
            $lineUser->getOriginal()['id'],
            $tokenProvider,
            $userRepository->getUserByUsername($request->username, $signType)
        );
        return responseSuccess();
    }

    /**
     * 用户本地没有登录过 Line, 但希望将帐号绑定到 Line 时使用
     * @param Request $request
     * @param LineUserRepository $lineUserRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindLine(Request $request, LineUserRepository $lineUserRepository)
    {
        $decoded = JWT::decode($request->line_token, env('LINE_CLIENT_SECRET'), ['HS256']);
        $tokenProvider = '';
        if ($request->user()->sign_type === 'teacher') {
            $tokenProvider = 'teachers';
        } else if ($request->user()->sign_type === 'student') {
            $tokenProvider = 'students';
        }

        $lineUserRepository->create($decoded->sub, $tokenProvider, $request->user());

        return responseSuccess();
    }


    public function switchUser(Request $request, LineUserRepository $lineUserRepository, UserRepository $userRepository)
    {
        $lineUser = $lineUserRepository->findByUser($request->user());
        return $this->commonSwitchUser($request, $lineUserRepository, $userRepository, $lineUser);
    }

}