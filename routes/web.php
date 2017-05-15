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

Route::get('/', function () {
    return view('welcome');
});
//Route::any('index',function(){
//    return view('layouts.main_layout');
//});

/**
 * 后台操作
 */
Route::group(['prefix' => 'admin'], function () {
    Route::any('index',['uses'=>'AdminController@index','as'=>'index']);
    Route::any('login',['uses'=>'Admin\LoginController@login','as'=>'login']);
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


