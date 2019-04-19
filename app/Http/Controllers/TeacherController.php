<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TeacherRepository;

class TeacherController extends UserController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param TeacherRepository $teacherRepository
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TeacherRepository $teacherRepository)
    {
        $result = $teacherRepository->index($request->user()->id);
        return responseSuccess($result);
    }
}
