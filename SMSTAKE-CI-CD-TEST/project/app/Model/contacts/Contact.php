<?php

namespace App\Model\contacts;

use App\Model\group\Group;
use App\SMS\Constants\DBTable;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = DBTable::TblContact;

    protected $fillable = [
        'contact_name',
        'group_id',
        'mobile_number',
        'email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
    	return $this->belongsTo(Group::class,'group_id','id');
    }
}
