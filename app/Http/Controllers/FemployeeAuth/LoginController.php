<?php

namespace App\Http\Controllers\FemployeeAuth;

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
	    return redirect('femployee/login');
	}

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/femployee/dashboard';
	
	/**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $personal_email;
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->middleware('femployee.guest', ['except' => 'logout']);
		$this->personal_email = $this->findUsername();
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('femployee.auth.login');
    }
	
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
		return Auth::guard('femployee');
    }
	
	/**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $email = request()->input('email');
        $fieldType = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'personal_email' : 'email';
        request()->merge([$fieldType => $email]);
        return $fieldType;
    }
	
	/**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
		return $this->personal_email;
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
                'email' => 'required|email|exists:employment_form,personal_email',
                'password' => 'required|min:6'
            ], $messages);
        
        $credentials = $request->only('personal_email', 'password');

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

	        if (Auth::guard('femployee')->attempt($credentials)) {
	            // Authentication passed...
	            
	            //Checking if current user status
	            if(Auth::guard('femployee')->user()->personal_status != 'Active'){
	            	
	            	$msg = '';
	            	if(Auth::guard('femployee')->user()->personal_status == 'Terminated'){
						$msg = 'Your account is Terminated';
					}elseif(Auth::guard('femployee')->user()->personal_status == 'Applicant'){
						$msg = 'Your account is waiting for approve';
					}
	            	
	            	Auth::guard('femployee')->logout();
		            $validator->errors()->add('password', $msg);
		            return redirect('femployee/login')->withErrors($validator);
				}
				return redirect('femployee/dashboard');
	        } else {
                $validator->errors()->add('password', "These credentials do not match our records.");
                return back()->withErrors($validator)->withInput();
            }

            // if unsuccessful -> redirect back
            return redirect()->back()->withInput($request->only('password', 'remember'))->withErrors([
                'approve' => 'These credentials do not match our records.',
            ]);
            
		}    
    }	
    
}
