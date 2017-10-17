<?php

namespace App\Http\Middleware;

use App\Models\System\Menus;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Permission
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

        $route = Route::currentRouteName();
        if(!preg_match('/^public_/',$route) && !empty($route) && $route != 'home') //路由存在
        {
            $menu = new Menus();
            $status = $menu->checkMenuExists($route);
            if(!$status){
//                echo $route;
                return response()->view('errors.404');
            }
            //查看权限
           if(!Auth::user()->can($route)){
                return response()->view('errors.permission_deny');
           }
        }
        return $next($request);
    }
}
