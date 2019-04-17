<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    use HasMultiAuthApiTokens, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = ['type_desc', 'sign_type'];

    public function getTypeDescAttribute()
    {
        return '学员';
    }

    public function getSignTypeAttribute()
    {
        return 'student';
    }

    public function findForPassport($username) {
        return $this->where('username', $username)->first();
    }

}
