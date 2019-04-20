<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TeacherStudentRepository;

class TeacherStudentController extends Controller
{
    public function adminIndex(Request $request, TeacherStudentRepository $teacherStudentRepository)
    {
        return $teacherStudentRepository->index();
    }
    public function handleFollow(Request $request, TeacherStudentRepository $teacherStudentRepository)
    {
        return $teacherStudentRepository->switchFollowStatus($request->teacher_id, $request->user());
    }
}
