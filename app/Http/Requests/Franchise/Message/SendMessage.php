<?php

namespace App\Http\Requests\Franchise\Message;

use Illuminate\Foundation\Http\FormRequest;

class SendMessage extends FormRequest
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
            'sender_id' 		=> 'required',
            'sender_type' 		=> 'required',
            'reciever_id' 		=> 'required',
            'message_to' 		=> 'required',
            'message' 		    => 'required'

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $other_fields_error = "Something went wrong while sending the message";
        return [
            'sender_id.required' 	    => $other_fields_error,
            'sender_type.required'  	=> $other_fields_error,
            'reciever_id.required'  	=> $other_fields_error,
            'message_to.required'  	    => $other_fields_error,
        ];
    }
}
