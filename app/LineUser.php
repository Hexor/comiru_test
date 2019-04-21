<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineUser extends Model
{
    //
    public $incrementing = false;

    protected $guarded = [];

    protected $appends = ['sign_type'];

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'id', 'teacher_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function getSignTypeAttribute()
    {
        if (!empty($this->student_id)) {
            return 'student';
        } elseif (!empty($this->teacher_id)) {
            return 'teacher';
        }
    }
}
