<?php

namespace App\Http\Controllers\Foreground\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class QQLoginController extends Controller
{
    //
    public function qq(){
        return Socialite::with('qq')->redirect();
    }

    public function qqlogin(){
        $user = Socialite::driver('qq')->user();
        dd($user);
    }
}
