<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;

class LineAuthorized
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
            $decoded = JWT::decode($request->line_token, env('LINE_CLIENT_SECRET'), ['HS256']);
            if ($decoded->exp <= time()) {
                throw new Exception("expired");
            }
            // 对于通过此中间件的请求, 在 request() 中附加上该用户的 line_id
            request()->merge(['line_id' => $decoded->sub]);
        } catch (\Exception $e) {
            return responseUnauthorized('Line 授权已经失效, 请重试');
        }
        return $next($request);
    }
}
