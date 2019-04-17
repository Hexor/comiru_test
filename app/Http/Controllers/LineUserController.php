<?php

namespace App\Http\Controllers;

use App\Http\Controllers\traits\commonAuthTrait;
use App\LineUser;
use App\Repositories\LineUserRepository;
use App\Repositories\UserRepository;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class LineUserController extends Controller
{
    use commonAuthTrait;

    public function switchUser(Request $request, LineUserRepository $lineUserRepository, UserRepository $userRepository)
    {
        $lineUser = $lineUserRepository->findByID($request->line_id);
        return $this->commonSwitchUser($request, $lineUserRepository, $userRepository, $lineUser);
    }

    public function bindUser(Request $request, LineUserRepository $lineUserRepository, UserRepository $userRepository)
    {
        $signType = $request->sign_type;
        $lineID = $request->line_id;
        $tokenProvider = getTokenProvider($request);

        $response = $this->verifyAuthInfoBeforeBind($request, $lineID, $signType);
        if (!$response->isOk()) {
            return $response;
        }

        $target = $lineUserRepository->isUserBindLine($request->username, $signType);
        if ($target) {
            if ($target->id != $lineID) {
                throw new Exception('该帐号已经绑定的 Line 帐号不属于你, 绑定新帐号失败');
            }
        }

        $lineUserRepository->create(
            $lineID,
            $tokenProvider,
            $userRepository->getUserByUsername($request->username, $signType)
        );
        return responseSuccess();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LineUserRepository $lineUserRepository)
    {
        if (Route::currentRouteName() == 'get_line_users_from_line_auth') {
            $decoded = JWT::decode($request->line_token, env('LINE_CLIENT_SECRET'), ['HS256']);
            return $lineUserRepository->indexByLineID($decoded->sub);
        }

        return $lineUserRepository->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LineUser $lineUser
     * @return \Illuminate\Http\Response
     */
    public function show(LineUser $lineUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LineUser $lineUser
     * @return \Illuminate\Http\Response
     */
    public function edit(LineUser $lineUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\LineUser $lineUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LineUser $lineUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LineUser $lineUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineUser $lineUser)
    {
        //
    }
}
