<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use SoftDeletes, HasMultiAuthApiTokens, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = ['type_desc', 'sign_ype'];

    public function getTypeDescAttribute()
    {
        return '学员';
    }

    public function getSignypeAttribute()
    {
        return 'student';
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}
