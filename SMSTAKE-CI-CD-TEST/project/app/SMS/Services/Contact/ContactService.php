<?php

namespace App\SMS\Services\Contact;

use App\Model\contacts\Contact;
use Illuminate\Database\Eloquent\Builder;

class ContactService
{

    /**
     * @param $request
     * @return Builder
     */
    public function getListForDataTable($request)
    {
        $result = auth()->user()
                        ->contacts()
                        ->whereHas('group')
                        ->with('group');

        return $result;
    }
}