<?php
namespace App\Http\Controllers\Parent;

use Illuminate\Support\Facades\Auth;

class InsuranceController extends ClientController
{

	public function index()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		$client_id = Auth::guard()->user()->id;
        return (new ClientController)->viewInsurance($client_id);
    }
	
	public function edit()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		$client_id = Auth::guard()->user()->id;
        return (new ClientController)->viewInsurance($client_id);
    }
}