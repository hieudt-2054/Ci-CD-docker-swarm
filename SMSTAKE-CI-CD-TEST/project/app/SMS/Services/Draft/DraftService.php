<?php

namespace App\SMS\Services\Draft;

class DraftService
{
    /**
     * @param $request
     */
    public function getListForDataTable($request=null)
    {
        $result = auth()->user()->drafts();

        return $result->get();
    }
}