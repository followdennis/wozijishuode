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
        $guard = 'front';
        if(Auth::guard($guard)->guest()){
            //前台用户登录判定
            $currentRoute = $request->route()->uri();
            if($request->ajax() || $request->wantsJson()){
                return response('Unauthorized .',401);
            } else {
//                return redirect('/login');
                return response()->json(['state'=>0,'msg'=>'您还没有登陆']);
            }
        }
        return $next($request);
    }
}
