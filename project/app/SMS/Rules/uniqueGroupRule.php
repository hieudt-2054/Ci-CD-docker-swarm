<?php

namespace App\SMS\Rules;

use App\Model\group\Group;
use Illuminate\Contracts\Validation\Rule;

class uniqueGroupRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $group = auth()->user()->groups->where('group_name', $value)->first();

        if (!empty($group)) {
            if (request()->method() === 'PATCH' && $group->id == request()->segment(3)) {
                return true;
            }

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This group has already been taken, please enter a unique group.';
    }
}
