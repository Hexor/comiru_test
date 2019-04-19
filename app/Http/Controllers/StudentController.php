<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StudentRepository;

class StudentController extends UserController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param StudentRepository $studentRepository
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, StudentRepository $studentRepository)
    {
        return $studentRepository->index($request->user()->id);
    }
}
