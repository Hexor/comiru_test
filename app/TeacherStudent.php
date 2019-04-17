<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherStudent extends Model
{
    //
    protected $guarded = [];

    public function student() {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }
}
