<?php

namespace App\Http\Controllers\FranchiseAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Franchise;

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

    use LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

	use AuthenticatesUsers {
	    logout as performLogout;
	}

	public function logout(Request $request)
	{
	    $this->performLogout($request);
	    return redirect('franchise/login');
	}


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/franchise/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('franchise.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('franchise.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('franchise');
    }
	
	/**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    /*public function credentials(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials = array_add($credentials, 'status', 'Active');
        return $credentials;
    }*/
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
                'email' => 'required|email|exists:fusers,email',
                'password' => 'required|min:6'
            ], $messages);
        
        $credentials = $request->only('email', 'password');

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

	        if (Auth::guard('franchise')->attempt($credentials)) {
	            // Authentication passed...
	            
	            //Checking if current user status
				$franchise_id = Auth::guard('franchise')->user()->franchise_id;
				$getFranchise = Franchise::find($franchise_id);//print_r($getFranchise);exit();
				if(empty($getFranchise) || $getFranchise->status != 'Active'){
					Auth::guard('franchise')->logout();
					$validator->errors()->add('email', 'Your Franchise is Not Activated');
					return redirect('franchise/login')->withErrors($validator);
				}
				return redirect('franchise/dashboard');
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
