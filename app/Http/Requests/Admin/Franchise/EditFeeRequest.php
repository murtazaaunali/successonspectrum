<?php

namespace App\Http\Requests\Admin\Franchise;

use Illuminate\Foundation\Http\FormRequest;

class EditFeeRequest extends FormRequest
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
			    /*'fee_due_date' => 'required',
			    'monthly_royalty_fee' => 'required',
			    'monthly_advertising_fee' => 'required',
			    'renewal_fee' => 'required',*/
	        ];
		}else{
			return [];
		}
    }
}
