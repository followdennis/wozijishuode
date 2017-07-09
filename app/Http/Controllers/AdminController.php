<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //后台功能实现
    public function index(){
        $data['name'] = 'bb';
        return view('admin.main.index',$data);
    }
    public function file_upload(){
        return view('admin.carousel.index');
    }

    public function upload(Request $request){
        if($request->ajax()){
            return $request->json(['name'=>'xiaoming','Id'=>123]);
        }else{
            return $request->json(['name'=>'error','Id'=>321]);
        }
    }
}
