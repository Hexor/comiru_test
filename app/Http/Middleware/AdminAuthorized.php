<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;
use Exception;
use Illuminate\Support\Str;

class AdminAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $admin = Admin::where('remember_token', $this->bearerToken())->firstOrFail();
            if ($this->tokenExpiredTime() <= time()) {
                throw new Exception();
            }
            request()->merge(['admin' => $admin]);
        } catch (\Exception $e) {
            return responseUnauthorized('管理员登录信息已经过期, 请重新登录');
        }
        return $next($request);
    }
    public function bearerToken()
    {
        $header = request()->header('Authorization', '');

        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    private function tokenExpiredTime()
    {
        $token = $this->bearerToken();
        $tokenCreatedAt = Str::substr($token, env('ADMIN_TOKEN_STR_LENGTH'));
        return intval($tokenCreatedAt) + intval(env('ADMIN_TOKEN_EXPIRE_SECONDS'));
    }
}
