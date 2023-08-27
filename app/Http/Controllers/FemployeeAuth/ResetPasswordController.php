<?php

namespace App\Http\Controllers\FemployeeAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

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
        $this->middleware('femployee.guest');
		$this->personal_email = $this->findUsername();
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('femployee.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('femployees');
    }

    /**
     * Get the guard to be used during password reset.
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
	
	protected function rules()
    {
        return [
            'token' => 'required',
            'personal_email' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }
	
	protected function credentials(Request $request)
    {
        return $request->only(
            'personal_email', 'password', 'password_confirmation', 'token'
        );
    }
}
