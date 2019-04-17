<?php

namespace App\Repositories;


use App\Exceptions\ApiException;
use App\LineUser;
use App\Student;
use App\Teacher;
use App\TeacherStudent;
use Exception;
use Symfony\Component\HttpFoundation\Response;

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
