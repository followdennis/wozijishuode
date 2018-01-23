<?php

namespace App\Http\Controllers\Foreground;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index(){
        return view('foreground.index',['cate_name'=>'']);
    }

    public function lists(){
        return view('foreground.ch',['cate_name'=>'abc']);
    }
    public function detail(){
        return view('foreground.detail',['cate_name'=>'ddd']);
    }
    public function search(){
        return view('foreground.search');
    }
}
