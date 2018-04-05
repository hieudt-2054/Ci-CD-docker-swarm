<?php

namespace App\SMS\Requests\SenderID;

use App\SMS\Constants\DBTable;
use Illuminate\Foundation\Http\FormRequest;

class SenderIDRequest extends FormRequest
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
        $rules = [
            'sender_name' => 'required|unique:'.DBTable::TblSenderId.'|alpha|size:6',
        ];

        return $rules;
    }
}
