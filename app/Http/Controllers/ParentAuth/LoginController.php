<?php

namespace App\Http\Controllers\ParentAuth;

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

    /*use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }*/
	use LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

	use AuthenticatesUsers {
	    logout as performLogout;
	}
	
	public function logout(Request $request)
	{
	    $this->performLogout($request);
	    return redirect('parent/login');
	}

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/parent/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('parent.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('parent.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('parent');
    }
	
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
                'email' => 'required|email|exists:admission_form,email',
                'password' => 'required|min:6'
            ], $messages);
        
        $credentials = $request->only('email', 'password');

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

	        if (Auth::guard('parent')->attempt($credentials)) {
	            // Authentication passed...
	            //Checking if current user status
				if(Auth::guard('parent')->user()->client_status != 'Active'){
					Auth::guard('parent')->logout();
					$validator->errors()->add('email', 'Your Account is Not Activated');
					return redirect('parent/login')->withErrors($validator);
				}
				return redirect('parent/dashboard');
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
