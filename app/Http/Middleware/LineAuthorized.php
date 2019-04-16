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
                throw new Exception("expired", 401);
            }
        } catch (\Exception $e) {
            return responseUnauthorized('Line 授权已经失效, 请重试');
        }
        return $next($request);
    }
}
