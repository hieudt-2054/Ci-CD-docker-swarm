<?php

namespace App\SMS\Services\Group;

use App\Model\group\Group;
use Illuminate\Database\Eloquent\Builder;

class GroupService
{

    public function groupCreatedByLoggedUser()
    {
        return auth()->user()->groups();
    }
    /**
     * @param $request
     * @return Builder
     */
    public function getListForDataTable($request)
    {
        $result = $this->groupCreatedByLoggedUser()->withCount('contacts');

        return $result->get();
    }
}