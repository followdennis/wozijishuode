<?php

namespace App\Http\Controllers\Foreground\Auth;

use App\Models\SystemLog;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;

    protected $redirectTo = '/';
    protected $username;
    protected $sysLogModel;

    public function __construct(SystemLog $systemLog)
    {
        $this->middleware('guest:front', ['except' => 'logout']);
//        $this->username = config('admin.global.username');
        $this->sysLogModel = $systemLog;
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
        //记录退出日志
        $id = session('sys_log_front_id_'.Auth::guard('front')->user()->id,0);

        $this->sysLogModel->update_log_out($id,1);//前台用户退出
        $this->guard()->logout();

        $request->session()->invalidate();


        return redirect('/login');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            //登陆成功
            $params = [
                'user_id'=>Auth::guard('front')->user()->id,
                'user_name'=>Auth::guard('front')->user()->name,
                'login_ip'=>$request->getClientIp(),
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'user_type'=>1,//前台用户
                'is_login'=>1,
                'login_address'=>''
            ];
            $id = $this->sysLogModel->record_login($params);
            session(['sys_log_front_id_'.Auth::guard('front')->user()->id => $id]);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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
