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
Route::any('test/{id?}',['uses'=>'TestController@test','as'=>'test']);

//Route::any('index',function(){
//    return view('layouts.main_layout');
//});

/**
 * 后台操作
 */
Route::group(['prefix' => 'back'], function () {
    Route::any('/',['uses'=>'Admin\IndexController@index','as'=>'index']);
    Route::any('index',['uses'=>'Admin\IndexController@index','as'=>'index']);
    Route::any('fileupload',['uses'=>'Admin\IndexController@file_upload']);
    Route::any('/upload',['uses'=>'Admin\IndexController@upload']);
    Route::any('login',['uses'=>'Admin\LoginController@login','as'=>'login']);
    Route::any('sidebar',function(){
        return view('partial.leftmenu');
    });
});

Route::group(['domain'=>'m.wozijishuode.cc'],function(){
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
Route::group(['domain'=>'www.wozijishuode.cc','prefix'=>'back'],function(){
    Route::any('index', ['uses'=>'Admin\IndexController@index']);
});
Route::group(['domain'=>'www.wozijishuode.cc'],function(){
    Route::any('/',function(){
        return '嘿嘿';
    });
});


Route::any('spider',['uses'=>'TestController@spider','as'=>'spider']);
Route::any('querylist',['uses'=>'TestController@query_list','as'=>'querylist']);


