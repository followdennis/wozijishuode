<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use App\Models\System\FriendLink;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class FriendLinkController extends AdminController
{
    //
    protected $friendModel;
    public function __construct(Request $request,FriendLink $friendLink)
    {
        parent::__construct($request);
        $this->friendModel = $friendLink;
    }
    public function index(){
        return view('admin.system.friendLink.index');
    }
    public function get_list(Request $request){
        $list = $this->friendModel->getList();
        $sort = $request->get('sort');
        return Datatables::of($list)
            ->editColumn('action',function($record){
                return '<a href="">编辑</a>';
            })
            ->filter(function($query) use ( $request){
                if($request->has('keyword')){
                    $keyword = trim($request->get('keyword'));
                    $query->where('name','like',"%$keyword%");
                }
                $query->orderBy('sort','desc');
            })
            ->make(true);
    }
    public function add(){

    }
    public function edit(){

    }
    public function del(){

    }
}
