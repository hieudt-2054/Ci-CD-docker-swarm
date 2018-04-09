<?php

namespace App\SMS\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        $rule   = [
            'group_id'      => 'required',
            'contact_name'  => 'required|max:24',
            'mobile_number' => [
                'required',
                'regex:/^(\+){0,1}(91){0,1}(-|\s){0,1}[0-9]{10}$/u'
            ],
            'email'         => 'required|email|max:150',
        ];

        return $rule;
    }
}
