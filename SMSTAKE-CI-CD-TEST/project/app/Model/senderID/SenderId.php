<?php

namespace App\Model\senderID;

use App\Model\sms\Sms;
use App\SMS\Constants\DBTable;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SenderId extends Model
{
    protected $table = DBTable::TblSenderId;

    protected $fillable = [
        'sender_name',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sms()
    {
        return $this->hasMany(Sms::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }
}
