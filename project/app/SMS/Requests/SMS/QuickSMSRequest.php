<?php

namespace App\SMS\Requests\SMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuickSMSRequest extends FormRequest
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
            'sender_id'      => 'required',
            'phone_number'   => 'required_without:group',
            'language'       => 'required',
            'text_message'   => 'required_unless:language, ""',
            'is_schedule'    => 'required',
            'date_scheduled' => 'required_if:is_schedule, 1',
            'group_numbers'  => 'required_unless:group, ""',
        ];
    }

    public function messages()
    {
        return [
            'phone_number.required_without' => 'The phone number field is required.',
            'text_message.required_unless'      => 'The message field is required.',
            'date_scheduled.required_if'    => 'The date scheduled field is required.',
            'group_numbers.required_unless' => 'The group number field is required.',
        ];
    }
}
