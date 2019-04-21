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
    public function relatedIndex(Request $request, TeacherRepository $teacherRepository)
    {
        $result = $teacherRepository->index($request->user()->id);
        return responseSuccess($result);
    }

    public function adminIndex(Request $request, TeacherRepository $teacherRepository)
    {
        return $teacherRepository->index();
    }

    public function store(Request $request, TeacherRepository $teacherRepository)
    {
        request()->merge(['sign_type' => 'teacher']);
        $proxy = Request::create('/api/auth/signup', 'POST', $request->all());
        return app()->handle($proxy);
    }

    public function delete(Request $request, TeacherRepository $teacherRepository, $id)
    {
        request()->merge(['id' => $id]);
        $this->validate($request, [
            'id' => 'required|exists:teachers,id',
        ]);
        return $teacherRepository->delete($id);
    }
}
