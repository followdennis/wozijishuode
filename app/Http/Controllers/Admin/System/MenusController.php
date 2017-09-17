<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class MenusController extends AdminController
{
    //
    public function index(){

        return view('Admin.System.menu');
    }
}
