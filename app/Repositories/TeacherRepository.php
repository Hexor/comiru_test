<?php

namespace App\Repositories;


use App\Exceptions\ApiException;
use App\LineUser;
use App\Student;
use App\Teacher;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class TeacherRepository
{
    public function index($studentID = null)
    {
        if ($studentID) {
            return Teacher::with('followed')->get();
        } else {
            return Teacher::all();
        }
    }
}
