<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use App\Models\System\Menus;
use App\Services\Tree;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MenusController extends AdminController
{
    //
    protected $menuModel;
    public function __construct(Request $request,Menus $menus)
    {
        parent::__construct($request);
        $this->menuModel = $menus;
    }

    public function index(){
        return view('admin.system.menu');
    }
    public function get_list(Request $request){
        $data_list = $this->menuModel->getList();
        $json =  Datatables::of($data_list)
            ->editColumn('is_show',function($record){
                if($record->is_show == 1){
                    return '是';
                }else{
                    return '否';
                }
            })
            ->addColumn('action',function($record){
                return '<a href="javascript:;" class="btn btn-sm green item_edit"><i class="fa fa-edit"></i>编辑</a>';
            })
            ->make(true);
            $json = htmlspecialchars_decode($json);//防止无法解析其中的引号
            preg_match('/{.*/',$json,$out);//把json的请求头过滤掉
            $m = $out[0];
            $new = json_decode($m,true);
            $arr = $new['data'];//这个数据有可能为空，所以要加个判断
            if(!empty($arr)){
                $tree = new Tree();
                $tree->init($arr);
                $str = "\$spacer\$name";
                $tree_new = $tree->get_tree(0,$str);
                $new['data'] = $tree_new;
            }
            return response()->json($new);
    }


}
