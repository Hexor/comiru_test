<?php

namespace App\Repositories;

use App\Student;
use App\TeacherStudent;

class StudentRepository
{
    public function index($teacherID = null)
    {
        if ($teacherID) {
            return TeacherStudent::where('teacher_id', $teacherID)->with('student')->get();
        } else {
            return Student::all();
        }
    }
}
