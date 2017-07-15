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
    Route::any('/',['uses'=>'AdminController@index','as'=>'index']);
    Route::any('index',['uses'=>'AdminController@index','as'=>'index']);
    Route::any('fileupload',['uses'=>'AdminController@file_upload']);
    Route::any('/upload',['uses'=>'AdminController@upload']);
    Route::any('login',['uses'=>'Admin\LoginController@login','as'=>'login']);
    Route::any('sidebar',function(){
        return view('partial.leftmenu');
    });
});
Route::any('/',function(){
   return view('mobile.index');
});
Route::any('indexhtml',function(){
    return view('mobile.index');
});
Route::any('listhtml',function(){
    return view('mobile.list');
});
Route::any('detailhtml',function(){
    return view('mobile.detail');
});

Route::any('spider',['uses'=>'TestController@spider','as'=>'spider']);
Route::any('querylist',['uses'=>'TestController@query_list','as'=>'querylist']);


