<?php

namespace App\Http\Requests\Admin\Franchise;

use Illuminate\Foundation\Http\FormRequest;

class CreateFranchiseRequest extends FormRequest
{
	protected $forceJsonResponse = true;
	
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
		    /*'franchise_name' => 'required',
		    'location' => 'required',
		    'city' => 'required',
		    //'location' => 'required',
		    'address' => 'required',
		    'email' => 'required|email|unique:franchises,email',
		    'phonenumber' => 'required',
		    'state' => 'required',
		    //'client_address' => 'required',
		    //'client_city' => 'required',
		    //'client_zipcode' => 'required',
		    //'client_state' => 'required',
		    'owner_name' => 'required',
		    'owner_email' => 'required',
		    'owner_contact' => 'required',
		    'monthly_royalty_fee' => 'required',
		    'monthly_advertising_fee' => 'required',
		    'renewal_fee' => 'required',
		    //'franchise_activation_date' => 'required',
		    'fdd_signed_date' => 'required',
		    'fdd_expiration_date' => 'required',*/
        ];
        
    }
}
