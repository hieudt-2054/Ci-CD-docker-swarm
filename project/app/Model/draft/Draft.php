<?php

namespace App\Model\draft;

use App\SMS\Constants\DBTable;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $table = DBTable::TblDraft;

    protected $fillable = [
        'draft_message', 'user_id', 'draft_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
