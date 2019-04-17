<?php

namespace App\Http\Controllers;

use App\Repositories\TeacherStudentRepository;
use App\TeacherStudent;
use Illuminate\Http\Request;

class TeacherStudentController extends Controller
{

    public function handleFollow(Request $request, TeacherStudentRepository $teacherStudentRepository)
    {
        return $teacherStudentRepository->switchFollowStatus($request->teacher_id, $request->user());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeacherStudent  $teacherStudent
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherStudent $teacherStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeacherStudent  $teacherStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(TeacherStudent $teacherStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeacherStudent  $teacherStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeacherStudent $teacherStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeacherStudent  $teacherStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherStudent $teacherStudent)
    {
        //
    }
}
