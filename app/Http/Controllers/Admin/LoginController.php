<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use AccountLogService;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    }

    /**
     * Show the application's login form.
     * 重写登录页面方法
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('system.login');
    }

    /**
     * Get the login username to be used by the controller.
     * 重写登录验证字段
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the guard to be used during authentication.
     * 重写看守器方法
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    //重写后台登陆
    public function login(Request $request)
    {
        if($request->isMethod('post')){

            $rule =[
                $this->username() => 'required | string',
                'password' => 'required | string',
                'captcha' => 'required|captcha'
            ];

            $messages=[
                $this->username().'.string'=>'登陆账号格式不正确',
                $this->username().'.required'=>'请输入登陆账号',
                'password.required'=>'请输入登陆密码',
                'captcha.required'=>'请输入登陆验证码',
                'captcha.captcha'=>'请输入正确的验证码'
            ];

            $validator = Validator::make($request->all(),$rule,$messages);

            if($validator->fails()){
                return showMessage($validator->errors()->first());
            }

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if (method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {

                //修改登录数据
                $account = Auth::guard('admin')->user();

                $accountData = [
                    'username'=>$account->username,
                    'id'=>$account->id
                ];

                $request->session()->put('accountData',$accountData);

                //event(new adminLogin($account));

                $account->login_num = $account->login_num+1;//登录次数
                $account->last_login_time = $account->login_time;//上次登录时间
                $account->login_time = now();//登录次数
                $account->updated_at = now();//登录次数

                $account->save();

                //写入后台日志
                accountLogService::write('登录后台',[]);

                return redirect('admin/menus');
            } else {
                return showMessage('账号或密码错误');
            }

        }

    }

    //退出
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('admin/login');
    }
}
