<?php

namespace App\Http\Requests\Admin\CargoHold;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentRequest extends FormRequest
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
        return [
            'document' 		=> 'required|mimes:pdf,docx|max:2000',
            'title' 		=> 'required',
            //'expiration' 	=> 'required',
            'category' 		=> 'required',
            //'user_type' 	=> 'required',
        ];
    }
    
    
	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
	    return [
	        'document.required' 	=> 'Document is required',
	        'document.mimes'  		=> 'Upload only pdf or doc format',
	        'user_type.required'  	=> 'Must select atleast one option',
	    ];
	}    
}
