<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfile extends FormRequest
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
            'email'             => 'required|email|max:255|unique:admins,id,' . Auth::guard()->user()->id,
            'password'          => 'nullable|min:6|confirmed',
            'profile_picture'   => 'mimes:jpeg,bmp,png,jpg,gif'
        ];
    }
}
