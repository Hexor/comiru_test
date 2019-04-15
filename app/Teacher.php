<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasMultiAuthApiTokens, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findForPassport($username) {
        return $this->where('username', $username)->first();
    }
}
