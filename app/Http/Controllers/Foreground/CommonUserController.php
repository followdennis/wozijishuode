<?php

namespace App\Http\Controllers\Foreground;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommonUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth.front:front');
    }

    public function index(){
        $user = Auth::guard('front')->user()->name;
        dd($user);
    }
}
