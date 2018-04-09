<?php

namespace App;

use App\Model\contacts\Contact;
use App\Model\draft\Draft;
use App\Model\group\Group;
use App\Model\senderID\SenderId;
use App\Model\sms\Sms;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function senderIds()
    {
        return $this->hasMany(SenderId::class);
    }

    public function drafts()
    {
        return $this->hasMany(Draft::class);
    }

    public function sms()
    {
        return $this->hasMany(Sms::class);
    }
}
