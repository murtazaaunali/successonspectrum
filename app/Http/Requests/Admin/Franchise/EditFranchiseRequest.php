<?php

namespace App\Http\Requests\Admin\Franchise;

use Illuminate\Foundation\Http\FormRequest;

class EditFranchiseRequest extends FormRequest
{
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
    	if($this->isMethod('post')){
	        return [
			    //'franchise_activation_date' => 'required',
			    //'franchise_name' => 'required',
			    'location' => 'required',
			    /*'city' => 'required',
			    'address' => 'required',
			    'email' => 'required|email|unique:franchises,email,'.FormRequest::segment(4),
			    'phonenumber' => 'required',*/
			    //'client_address' => 'required',
			    //'client_city' => 'required',
			    //'client_zipcode' => 'required',
			    //'client_state' => 'required',
			    //'state' => 'required',
	        ];
		}else{
			return [];
		}
		
    }
}
