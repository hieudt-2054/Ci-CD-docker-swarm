<?php

namespace App\SMS\Services\SenderID;

use App\Model\senderID\SenderId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SenderIDService
{
    public function senderCreatedByLoggedUser()
    {
        return auth()->user()->senderIds();
    }
    /**
     * @return Collection
     */
    public function getListForDataTable($request)
    {
        $result = $this->senderCreatedByLoggedUser()
                        ->select(['id','sender_name','status','created_at'])
                        ->where(function ($query) use($request){
                            if($request->has('searchStatus') && !empty($request->get('searchStatus'))){
                                $query->where('status', $request->get('searchStatus'));
                            }
                            if($request->has('filterValue') && !empty($request->get('filterValue'))){
                                if(!empty($request->get('filterBy'))){
                                    if($request->get('filterBy') == 1)
                                        $query->where('sender_name', $request->get('filterValue'));
                                    else {
                                        $startDate = substr($request->get('filterValue'), 0, 10);
                                        $endDate = substr($request->get('filterValue'), 13, 10);
                                        $query->whereBetween('created_at', [$startDate, $endDate]);
                                    }
                                }
                            }
                        })  ;

        return $result;
    }
}