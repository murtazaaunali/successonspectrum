<?php

namespace App\Http\Requests\Admin\Tripitinerary;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'selectadmin'		=> 'required',
            'eventdate'			=> 'required',
            'starttime'			=> 'required',
            'endtime'			=> 'required',
            'eventname'			=> 'required',
        ];
    }
}
