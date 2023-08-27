<?php

namespace App\Http\Requests\Femployee\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditEmployeeRequest extends FormRequest
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
	            'employee_fullname' 	=> 'required',
	            'employee_title' 		=> 'required',
	            'employee_address' 		=> 'required',
	            'hiring_date' 			=> 'required',
	            'employee_type' 		=> 'required',
	            'completion_date' 		=> 'required',
	            'highest_degree_held' 	=> 'required',
	            'employee_ss' 			=> 'required',
	            'employee_email' 		=> 'required|email|unique:employment_form,personal_email,'.Auth::user()->id,
	        ];
    	}else{
	        return [
	            //
	        ];
			
		}

    }

}
