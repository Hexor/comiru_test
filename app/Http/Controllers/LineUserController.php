<?php

namespace App\Http\Controllers;

use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Route;
use App\Repositories\LineUserRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\traits\CommonAuthTrait;

class LineUserController extends Controller
{
    use CommonAuthTrait;

    public function switchUser(Request $request, LineUserRepository $lineUserRepository, UserRepository $userRepository)
    {
        $lineUser = $lineUserRepository->findByID($request->line_id);
        return $this->commonSwitchUser($request, $lineUserRepository, $userRepository, $lineUser);
    }

    /**
     * @param Request $request
     * @param LineUserRepository $lineUserRepository
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
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
            if ($target->getOriginal()['id'] != $lineID) {
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
            $result = $lineUserRepository->indexByLineID($decoded->sub);
        } else {
            $result = $lineUserRepository->index();
            if (empty($result)) {
                return responseError('Line 授权已经失效, 请重新登录或绑定', Response::HTTP_UNAUTHORIZED, '/auth/login');
            }
        }

        return responseSuccess($result);
    }

    public function adminIndex(Request $request, LineUserRepository $lineUserRepository)
    {
        return $lineUserRepository->all();
    }

    public function deleteStudent(Request $request, LineUserRepository $lineUserRepository, $id)
    {
        request()->merge(['id' => $id]);
        $this->validate($request, [
            'id' => 'required|exists:line_users,student_id',
        ]);
        return $lineUserRepository->delete($id, 'student_id');
    }

    public function deleteTeacher(Request $request, LineUserRepository $lineUserRepository, $id)
    {
        request()->merge(['id' => $id]);
        $this->validate($request, [
            'id' => 'required|exists:line_users,teacher_id',
        ]);
        return $lineUserRepository->delete($id, 'teacher_id');
    }
}
