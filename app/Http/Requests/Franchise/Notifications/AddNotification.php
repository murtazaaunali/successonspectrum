<?php

namespace App\Http\Requests\Franchise\Notifications;

use Illuminate\Foundation\Http\FormRequest;

class AddNotification extends FormRequest
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
            'attachment' 	=> 'mimes:pdf,docx,jpg,png,jpeg,gif',
            'title' 		=> 'required',
            'type' 		    => 'required',
            'select_user' 	=> 'required',
            'description' 	=> 'required',
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
            'attachment.mimes'  		=> 'Only Doc/PDF or Image files are allowed in Attachment',
            'title.required'  	        => 'The Notification Title field is required.',
            'franchises.required'  	    => 'Must Select Atleast one Franchise',
            'type.required'  	        => 'The Notification Type field is required.',
            'select_user.required'  	=> 'The User Select field is required.',
        ];
    }
}
