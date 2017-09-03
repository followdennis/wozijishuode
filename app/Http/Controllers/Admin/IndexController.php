<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Menus;
use App\Services\Tree;
use Illuminate\Http\Request;


class IndexController extends AdminController
{
    //
    public function __construct()
    {
        parent::__construct();

    }

    //后台功能实现
    public function index(){
        $data['name'] = 'bb';
//        $list = $this->menusModel->getAllList();
//        $tree = new Tree();
//        $new_list = $tree->tree($list);
//        $tree->makehtml($new_list);
//        $data['menu'] = $tree->str;
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
