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
         * 文章管理
         */
        Route::any('/articles',['uses'=>'Admin\ArticlesManage\IndexController@index','as'=>'articles']);
        Route::any('/articles/list',['uses'=>'Admin\ArticlesManage\IndexController@get_list','as'=>'articles/list']);
        Route::any('/articles/show',['uses'=>'Admin\ArticlesManage\IndexController@show','as'=>'articles/show']);
        Route::any('/articles/add',['uses'=>'Admin\ArticlesManage\IndexController@add','as'=>'articles/add']);
        Route::any('/articles/edit',['uses'=>'Admin\ArticlesManage\IndexController@edit','as'=>'articles/edit']);
        Route::any('/articles/del',['uses'=>'Admin\ArticlesManage\IndexController@del','as'=>'articles/del']);
        /**
         * 分类管理category
         */
        Route::any('/category',['uses'=>'Admin\ArticlesManage\CategoryController@index','as'=>'category']);//分类管理
        Route::any('/category/list',['uses'=>'Admin\ArticlesManage\CategoryController@get_list','as'=>'category/list']);//分类列表
        Route::any('/category/edit',['uses'=>'Admin\ArticlesManage\CategoryController@edit','as'=>'category/edit']);//编辑分类
        Route::any('/category/del',['uses'=>'Admin\ArticlesManage\CategoryController@del','as'=>'category/del']);//删除分类
        Route::any('/category/add',['uses'=>'Admin\ArticlesManage\CategoryController@add','as'=>'category/add']);//添加分类

        /**
         * 标签管理
         */
        Route::any('/tags',['uses'=>'Admin\ArticlesManage\TagsController@index','as'=>'tags']);
        Route::any('/tags/list',['uses'=>'Admin\ArticlesManage\TagsController@get_list','as'=>'tags/list']);
        Route::any('/tags/edit',['uses'=>'Admin\ArticlesManage\TagsController@edit','as'=>'tags/edit']);
        Route::any('/tags/del',['uses'=>'Admin\ArticlesManage\TagsController@del','as'=>'tags/del']);
        Route::any('/tags/add',['uses'=>'Admin\ArticlesManage\TagsController@add','as'=>'tags/add']);
        /**
         * 内链管理
         */
        Route::any('innerlink',['uses'=>'Admin\ArticlesManage\InnerLinkController@index','as'=>'innerlink']);
        Route::any('innerlink/list',['uses'=>'Admin\ArticlesManage\InnerLinkController@get_list','as'=>'innerlink/list']);
        Route::any('innerlink/add',['uses'=>'Admin\ArticlesManage\InnerLinkController@add','as'=>'innerlink/add']);
        Route::any('innerlink/edit',['uses'=>'Admin\ArticlesManage\InnerLinkController@edit','as'=>'innerlink/edit']);
        Route::any('innerlink/del',['uses'=>'Admin\ArticlesManage\InnerLinkController@del','as'=>'innerlink/del']);
        /**
         * 评论管理
         */
        Route::any('comments',['uses'=>'Admin\ArticlesManage\CommentsController@index','as'=>'comments']);
        Route::any('comments/list',['uses'=>'Admin\ArticlesManage\CommentsController@get_list','as'=>'comments/list']);
        Route::any('comments/del',['uses'=>'Admin\ArticlesManage\CommentsController@del','as'=>'comments/del']);

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
        /**
         * 友情链接
         */
        Route::any('friend_link',['uses'=>'Admin\System\FriendLinkController@index','as'=>'friend_link']);
        Route::any('friend_link/add',['uses'=>'Admin\System\FriendLinkController@add','as'=>'friend_link/add']);
        Route::any('friend_link/edit',['uses'=>'Admin\System\FriendLinkController@edit','as'=>'friend_link/edit']);
        Route::any('friend_link/del',['uses'=>'Admin\System\FriendLinkController@del','as'=>'friend_link/del']);
        Route::any('friend_link/list',['uses'=>'Admin\System\FriendLinkController@get_list','as'=>'friend_link/list']);
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




