<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//test
Route::any('test_view',function(){
    return view('test');
});
Route::any('test',['uses'=>'TestController@test','as'=>'test']);
Route::any('test2',['uses'=>'TestController@test2','as'=>'test2']);
Route::any('abctest/{id}',['uses'=>'TestController@test','as'=>'test/{id}']);
Route::any('view',function(){
    return view('layouts.common');
});
//Route::any('index',function(){
//    return view('layouts.main_layout');
//});

/**
 * 后台操作
 */
Route::group(['domain'=>'www.wozijishuode.com','prefix'=>'back'],function(){
    Auth::routes();
    Route::group(['middleware'=>['permissions','auth']],function(){

        //    Route::get('/home', 'HomeController@index')->name('home');
        Route::any('/',['uses'=>'Admin\IndexController@index','as'=>'home']);
        Route::any('/home',['uses'=>'Admin\IndexController@index','as'=>'home']);
        Route::any('index',['uses'=>'Admin\IndexController@index','as'=>'index']);
        Route::any('fileupload',['uses'=>'Admin\IndexController@file_upload']);
        Route::any('/upload',['uses'=>'Admin\IndexController@upload']);
        Route::any('/add_role',['uses'=>'Admin\IndexController@add_role']);
//    Route::any('login',['uses'=>'Admin\LoginController@login','as'=>'login']);

        /**
         * 系统管理
         */
        /**
         * 菜单管理
         */
        Route::any('menus',['uses'=>'Admin\System\MenusController@index','as'=>'menus']);
        Route::any('menus/list',['uses'=>'Admin\System\MenusController@get_list','as'=>'menus/list']);
        Route::any('menus/add',['uses'=>'Admin\System\MenusController@add','as'=>'menus/add']);
        Route::any('menus/edit',['uses'=>'Admin\System\MenusController@edit','as'=>'menus/edit']);
        Route::any('menus/del',['uses'=>'Admin\System\MenusController@del','as'=>'menus/del']);
        /**
         * 角色管理
         */
        Route::any('role',['uses'=>'Admin\System\RoleController@index','as'=>'role']);
        Route::any('role/list',['uses'=>'Admin\System\RoleController@get_list','as'=>'role/list']);
        Route::any('role/add',['uses'=>'Admin\System\RoleController@add','as'=>'role/add']);
        Route::any('ajax_role/check_role_exist',['uses'=>'Admin\System\RoleController@checkRoleNameUnique','as'=>'ajax_role/check_role_exist']);
        Route::any('role/edit',['uses'=>'Admin\System\RoleController@edit','as'=>'role/edit']);
        Route::any('role/del',['uses'=>'Admin\System\RoleController@del','as'=>'role/del']);
        Route::any('role/power',['uses'=>'Admin\System\RoleController@power','as'=>'role/power']);
        Route::any('role/member',['uses'=>'Admin\System\RoleController@member','as'=>'role/member']);//展示及列表
        Route::any('role/member_del',['uses'=>'Admin\System\RoleController@member_del','as'=>'role/member_del']);
        /**
         * 用户管理
         */
        Route::any('user',['uses'=>'Admin\System\UserController@index','as'=>'user']);
        Route::any('user/list',['uses'=>'Admin\System\UserController@get_list','as'=>'user/list']);
        Route::any('user/edit',['uses'=>'Admin\System\UserController@edit','as'=>'user/edit']);
        Route::any('user/add',['uses'=>'Admin\System\UserController@add','as'=>'user/add']);
        Route::any('user/del',['uses'=>'Admin\System\UserController@del','as'=>'user/del']);
        Route::any('user/check_exists',['uses'=>'Admin\System\UserController@check_exists','as'=>'user/check_exists']);
        Route::any('sidebar',function(){
            return view('partial.leftmenu');
        });
    });

});
//前台
Route::group(['domain'=>'www.wozijishuode.com'],function(){
    Route::any('/',function(){
        return '嘿嘿';
    });
});
//前台
Route::group(['domain'=>'www.wozijishuode.com','prefix'=>'wechat'],function(){
    Route::any('/',function(){
        return '微信';
    });
});
//移动端
Route::group(['domain'=>'m.wozijishuode.com'],function(){
    Route::any('/',function(){
        return view('mobile.index');
    });
    Route::any('list',function(){
        return view('mobile.list');
    });
    Route::any('detail',function(){
        return view('mobile.detail');
    });
});

Route::any('spider',['uses'=>'TestController@spider','as'=>'spider']);
Route::any('querylist',['uses'=>'TestController@query_list','as'=>'querylist']);




