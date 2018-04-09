<?php

namespace App\Model\sms;

use App\Model\senderID\SenderId;
use App\SMS\Constants\DBTable;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $table = DBTable::TblSms;

    protected $fillable = [
        'sender_id',
        'language',
        'user_id',
        'text_message',
        'date_scheduled',
        'is_schedule',
        'credit'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function senderId()
    {
        return $this->belongsTo(SenderId::class);
    }
}
