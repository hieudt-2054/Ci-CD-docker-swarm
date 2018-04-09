<?php

namespace App\SMS\Requests\Groups;

use App\SMS\Constants\DBTable;
use App\SMS\Rules\uniqueGroupRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupRequest extends FormRequest
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
        $rule = [
            'group_name' => [
                'required',
                'max: 16',
                new uniqueGroupRule()
            ],
        ];

        return $rule;
    }
}

/*'group_name' => [
                    'required',
                    Rule::unique(DBTable::TblGroup)->ignore(request()->segment(3), 'id')
                ],
*/