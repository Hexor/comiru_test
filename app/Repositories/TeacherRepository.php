<?php

namespace App\Repositories;

use App\Teacher;

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
