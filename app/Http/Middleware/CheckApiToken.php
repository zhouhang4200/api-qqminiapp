<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Cache;

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
        if ($token = $request->input('token')) {
            $user = Cache::rememberForever($token, function () use ($token) {
                return User::where('token', $token)->first();
            });

            if ($user) {
                return $next($request);
            }
        }

        return response()->json(['code' => 10000, 'message' => '您需要先登录', 'data' => '']);

//        if (auth()->guard('api')->check()) {
//            auth()->shouldUse('api');
//            return $next($request);
//        } else {
//            return response()->json(['code' => 10000, 'message' => 'token已过期，请重新登录', 'data' => '']);
//        }
    }
}
