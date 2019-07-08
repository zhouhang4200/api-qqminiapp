<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guard('api')->check()) {
            auth()->shouldUse('api');
            return $next($request);
        } else {
            return response()->json(['code' => 10000, 'message' => 'token已过期，请重新登录', 'data' => '']);
        }
    }
}
