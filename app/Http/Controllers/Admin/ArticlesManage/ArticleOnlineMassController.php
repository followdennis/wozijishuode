<?php

namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class ArticleOnlineMassController extends AdminController
{
    //
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index(){
        return view('admin.articleMass.index');
    }
    public function lists(Request $request){

    }
    public function edit(){
        echo 'edit';
    }
}
