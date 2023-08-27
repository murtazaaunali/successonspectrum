<?php

namespace App\Http\Requests\Franchise\User;

use Illuminate\Foundation\Http\FormRequest;

class AddUser extends FormRequest
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
            'fullname' 	    	=> 'required',
            'email'             => 'required|email|max:255|unique:fusers',
            'password'          => 'required|min:6|confirmed',
            'profile_picture'   => 'mimes:jpeg,bmp,png,jpg,gif|max:2048|dimensions:max_width=500,max_height=500'
        ];
    }
    
    public function messages(){
	    return [
	        'profile_picture.mimes' => 'Only images are allowed in Attachment',
	        'profile_picture.max' => 'File is to large',
	        'profile_picture.dimensions' => 'File Maximum width and hieght must be 500 x 500',
	    ];		
	}    
}
