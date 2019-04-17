<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LineUserRepository;
use Exception;
use Firebase\JWT\JWT;

trait UserTrait
{
    /**
     * 用户曾经绑定过 line, 但是没有持有 Line token, 并且希望绑定更多帐号时使用
     * @param Request $request
     * @param LineUserRepository $lineUserRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function bindUser(Request $request, LineUserRepository $lineUserRepository)
    {

        $currentLineUser = $lineUserRepository->isUserBindLine($request->user()->username);
        if (!$currentLineUser) {
            return responseUnauthorized('当前帐号没有绑定过 Line, 绑定新帐号失败');
        }

        if ($request->is_signup) {
            $exist = LineUser::where('id', $currentLineUser->id)->whereNotNull('teacher_id')->first();
            if ($exist) {
                throw new Exception('一个Line 帐号只能绑定一个教师帐号, 注册失败', Response::HTTP_CONFLICT);
            }
            $proxy = Request::create('/api/auth/signup', 'POST', $request->all());
        } else {
            $proxy = Request::create('/api/auth/signin', 'POST', $request->all());
        }
        $response = app()->handle($proxy);
        if (!$response->isOk()) {
            return $response;
        }


        $target = $lineUserRepository->isUserBindLine($request->username);
        if ($target) {
            if ($target->id != $currentLineUser->id) {
                throw new Exception('该帐号已经绑定的 Line 帐号不属于你, 绑定新帐号失败');
            }
        }

        $lineUserRepository->create($currentLineUser->id, getTokenProvider($request), $target->user);

        return responseSuccess();
    }

    /**
     * 用户登录过 Line, 并希望将帐号绑定到 Line 时使用
     * @param Request $request
     * @param LineUserRepository $lineUserRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindLine(Request $request, LineUserRepository $lineUserRepository)
    {
        $decoded = JWT::decode($request->line_token, env('LINE_CLIENT_SECRET'), ['HS256']);

        $lineUserRepository->create($decoded->sub, $request->token_provider, $request->user());

        return responseSuccess();
    }
}