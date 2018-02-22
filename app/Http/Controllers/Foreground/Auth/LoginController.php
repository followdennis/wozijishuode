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

    public function showLoginForm(Request $request)
    {
        if($request->filled('layer') && $request->get('layer') == 1){
            return view('foreground.auth.login_layer');
        }else{
            return view('foreground.auth.login');
        }
    }
    public function logout(Request $request)
    {
        //记录推出日志
//        $id = session('sys_log_id_'.Auth::user()->id,0);

//        $this->sysModel->update_log_out($id);
        $this->guard()->logout();

        $request->session()->invalidate();


        return redirect('/login');
    }

    //自定义登陆成功response
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?response()->json(['state'=>1,'msg'=>'弹出层登陆']): redirect()->intended($this->redirectPath());
    }
    protected function authenticated(Request $request, $user)
    {
        //layer标记值
        if($request->filled('layer') && $request->get('layer') == 1){
            return 1;
        }
    }
    protected function guard()
    {
        return auth()->guard('front');
    }
}
