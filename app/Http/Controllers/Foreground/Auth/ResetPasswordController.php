<?php

namespace App\Http\Controllers\Foreground\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    //
    use ResetsPasswords;
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('Foreground.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

}
