<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/back/home';

    /**
     * system_log 系统日志模型
     */
    protected $sysModel;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SystemLog $sys_log)
    {

        $this->middleware('guest', ['except' => 'logout']);
        $this->sysModel = $sys_log;
    }

    public function logout(Request $request)
    {
        //退出成功
        $id = session('sys_log_id_'.Auth::user()->id,0);

        $this->sysModel->update_log_out($id);
        $this->guard()->logout();

        $request->session()->invalidate();


        return redirect('/back/login');
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
                'user_id'=>Auth::user()->id,
                'user_name'=>Auth::user()->name,
                'login_ip'=>$request->getClientIp(),
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'is_login'=>1,
                'login_address'=>''
            ];
            $id = $this->sysModel->record_login($params);
            session(['sys_log_id_'.Auth::user()->id => $id]);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

}
