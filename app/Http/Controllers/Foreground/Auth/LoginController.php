<?php

namespace App\Http\Controllers\Foreground\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;

    protected $redirectTo = '/';
    protected $username;

    public function __construct()
    {
        $this->middleware('guest:front', ['except' => 'logout']);
//        $this->username = config('admin.global.username');
    }

    public function showLoginForm()
    {
        return view('foreground.auth.login');
    }

    protected function guard()
    {
        return auth()->guard('front');
    }
}
