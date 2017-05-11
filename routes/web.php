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
Route::any('test/{id}',['uses'=>'TestController@test','as'=>'test']);

Route::get('/', function () {
    return view('welcome');
});
//Route::any('index',function(){
//    return view('layouts.main_layout');
//});


Route::any('index',['uses'=>'AdminController@index','as'=>'index']);

