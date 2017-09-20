<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use App\Models\System\Menus;
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
        return Datatables::of($data_list)
            ->make(true);
    }
}
