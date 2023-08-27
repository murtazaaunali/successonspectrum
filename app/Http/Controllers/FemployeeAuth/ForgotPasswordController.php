<?php

namespace App\Http\Controllers\FemployeeAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
	
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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('femployee.auth.passwords.email');
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
	
	/**
	 * Change Email Column Name For Forgot Pasword 
	**/
	public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('personal_email')
        );
        
		/*return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);*/
		if($response == Password::RESET_LINK_SENT)
		{
			Session::flash('Success','<div class="alert alert-success">Your password reset instructions has been sent to your email.</div>');
			return $this->sendResetLinkResponse($request, $response);
		}
		else
		{
			return $this->sendResetLinkFailedResponse($request, $response);
		}						
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['personal_email' => 'required|email']);
    }
}
