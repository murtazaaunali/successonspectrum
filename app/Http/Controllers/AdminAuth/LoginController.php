<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    //use AuthenticatesUsers
    use LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

	use AuthenticatesUsers {
	    logout as performLogout;
	}

	public function logout(Request $request)
	{
	    $this->performLogout($request);
	    //return redirect('admin/login');
		return redirect('');
	}
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    
    /*public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            //exit;
			if(Auth::check() && Auth::user()->type == 'Employee'){
		        Auth::logout();
		        return redirect('/admin/login')->with('error_login', 'Your error text');
		    }  

            return redirect()->intended('dashboard');
        }		
	} */   
	
    public function login(Request $request)
    {
        $messages = [
            "email.required" => "Email is required",
            "email.email" => "Email is not valid",
            "email.exists" => "Email doesn't exists",
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 6 characters"
        ];

        $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:admins,email',
                'password' => 'required|min:6'
            ], $messages);
        
        $credentials = $request->only('email', 'password');

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

	        if (Auth::guard('admin')->attempt($credentials)) {
	            // Authentication passed...
	            
	            //Checking if current user is employee and his status
	            if(Auth::guard('admin')->user()->type == 'Employee' && Auth::guard('admin')->user()->employee_status == 0){
	            	Auth::guard('admin')->logout();
		            $validator->errors()->add('email', 'Your Account is Not Activated');
		            return redirect('admin/login')->withErrors($validator);
				}
	            return redirect('admin/dashboard');
	            
	        } else {
                $validator->errors()->add('email', 'These credentials do not match our records.');
                return back()->withErrors($validator)->withInput();
            }

            // if unsuccessful -> redirect back
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
                'approve' => 'These credentials do not match our records.',
            ]);
            
		}    
    }	
}
