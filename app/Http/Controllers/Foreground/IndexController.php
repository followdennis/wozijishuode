<?php

namespace App\Http\Controllers\Foreground;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index(){
        return view('foreground.index');
    }

    public function lists(){
        return view('foreground.lists');
    }
    public function detail(){
        return view('foreground.detail');
    }
    public function search(){
        return view('foreground.search');
    }
}
