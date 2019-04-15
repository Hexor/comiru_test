<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    private static $CLIENT_ID = 2;
    private static $CLIENT_SECRET = 'NoEtJmKV5sUUScA5AosfTjiu050vNBpZJNn4PPNc';

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
            'client_id' => $this::$CLIENT_ID,
            'client_secret' => $this::$CLIENT_SECRET,
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
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
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

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    private function getTokenProvider($request)
    {
        $tokenProvider = "";
        if ($request->signup_type === 'teacher') {
            $tokenProvider = 'teachers';
        } elseif ($request->signup_type === 'student'){
            $tokenProvider = 'students';
        }

        return $tokenProvider;

    }
}