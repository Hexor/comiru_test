<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineUser extends Model
{
    //
    protected $guarded = [];

    protected $hidden = [
        'id',
    ];

    public function teacher() {
        return $this->hasOne(Teacher::class , 'id' , 'teacher_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }
}
