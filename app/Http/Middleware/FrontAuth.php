<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FrontAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->guest()){
            //前台用户登录判定
            $currentRoute = $request->route()->uri();
            if($request->ajax() || $request->wantsJson()){
                return response('Unauthorized .',401);
            } else {
                return redirect('/login');
            }
        }
        return $next($request);
    }
}
