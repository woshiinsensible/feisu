<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->session()->has('user_token')){
            return $next($request);
        }else{
            echo '<script>location.href="/login";alert("用户没有登录，请先登录！");</script>';
            exit();
        }

    }
}
