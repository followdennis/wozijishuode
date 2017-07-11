<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

//            $data['data'] = ['name'=>'xiaoming','Id'=>'123','error'=>'','msg'=>'成功'];
//            Log::info('abc');
//            return response()->json($data);
        }
        else
        {

            $data['data'] = ['name'=>'xiaoming','Id'=>'123','error'=>'','msg'=>'成功'];

            return response()->json($data);
        }

    }
}
