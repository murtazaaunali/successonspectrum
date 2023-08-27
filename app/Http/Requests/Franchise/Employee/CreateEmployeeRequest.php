<?php

namespace App\Http\Requests\Franchise\Employee;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
            'employee_email' 		=> 'required|email|unique:employment_form,personal_email',
            'employee_name'			=> 'required',
            'employee_title'		=> 'required',
            'hiring_date'			=> 'required',
            'employee_type'			=> 'required',
            'completion_date'		=> 'required',
            'highest_degree'		=> 'required',
            'employee_ss'			=> 'required',
            'starting_pay'			=> 'required',
            'current_pay'			=> 'required',
            'insurance_plan'		=> 'required',
            'retirement_plan'		=> 'required',
            'paid_vacation'			=> 'required',
            'paid_holidays'			=> 'required',
            'sick_leaves'			=> 'required',
        ];
    }
}
