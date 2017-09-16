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
Route::any('test',['uses'=>'TestController@test','as'=>'test']);
Route::any('test2',['uses'=>'TestController@test2','as'=>'test2']);
Route::any('test/{id?}',['uses'=>'TestController@test','as'=>'test']);

//Route::any('index',function(){
//    return view('layouts.main_layout');
//});

/**
 * 后台操作
 */
Route::group(['domain'=>'www.wozijishuode.com','prefix'=>'back'],function(){
    Auth::routes();

//    Route::get('/home', 'HomeController@index')->name('home');
    Route::any('/',['uses'=>'Admin\IndexController@index','as'=>'home']);
    Route::any('/home',['uses'=>'Admin\IndexController@index','as'=>'home']);
    Route::any('index',['uses'=>'Admin\IndexController@index','as'=>'index']);
    Route::any('fileupload',['uses'=>'Admin\IndexController@file_upload']);
    Route::any('/upload',['uses'=>'Admin\IndexController@upload']);
    Route::any('/add_role',['uses'=>'Admin\IndexController@add_role']);
//    Route::any('login',['uses'=>'Admin\LoginController@login','as'=>'login']);

    Route::any('sidebar',function(){
        return view('partial.leftmenu');
    });
});
//前台
Route::group(['domain'=>'www.wozijishuode.com'],function(){
    Route::any('/',function(){
        return '嘿嘿';
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




