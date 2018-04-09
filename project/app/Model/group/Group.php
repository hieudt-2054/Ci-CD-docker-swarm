<?php

namespace App\Model\group;

use App\Model\contacts\Contact;
use App\SMS\Constants\DBTable;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = DBTable::TblGroup;

    protected $fillable = [
        'group_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    
}
