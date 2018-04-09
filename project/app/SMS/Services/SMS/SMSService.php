<?php

namespace App\SMS\Services\SMS;

use App\SMS\Constants\DBTable;

class SMSService
{
    public function getListForDataTable($request)
    {
        $result = auth()->user()
                        ->sms()
                        ->join(DBTable::TblSenderId, DBTable::TblSms.'.sender_id', '=', DBTable::TblSenderId.'.id')
                        ->where('is_schedule', 1)
                        ->select(DBTable::TblSenderId.'.id', DBTable::TblSenderId.'.sender_name', DBTable::TblSms.'.*')
                        ->where(
                            function ($query) use ($request) {
                                if ($request->has('status') && !empty($request->get('status'))) {
                                    $query->where(DBTable::TblSms.'.status', $request->get('status'));
                                }

                                if ($request->has('option') && !empty($request->get('option'))) {
                                    if ($request->get('option') == 3){
                                        if ($request->has('senderId') && !empty($request->get('senderId'))) {
                                            $query->where('sender_name', 'like', "%{$request->get('senderId')}%");
                                        }
                                    }

                                    if ($request->get('option') == 1){
                                        if ($request->has('startDate') && !empty($request->get('startDate'))) {
                                            $query->where('date_scheduled', '>=', $request->get('startDate').' 00:00:00');
                                            if ($request->has('endDate') && !empty($request->get('endDate'))) {
                                                $query->where('date_scheduled', '<=', $request->get('endDate').' 00:00:00');
                                            }
                                        }
                                    }

                                    if ($request->get('option') == 2){
                                        if ($request->has('startDate') && !empty($request->get('startDate'))) {
                                            $query->where(DBTable::TblSms.'.created_at', '>=', $request->get('startDate').' 00:00:00');
                                            if ($request->has('endDate') && !empty($request->get('endDate'))) {
                                                $query->where(DBTable::TblSms.'.created_at', '<=', $request->get('endDate').' 00:00:00');
                                            }
                                        }
                                    }
                                }
                            }
                        );

        return $result;
    }
}