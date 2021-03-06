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
    public function relatedIndex(Request $request, StudentRepository $studentRepository)
    {
        return $studentRepository->index($request->user()->id);
    }

    public function adminIndex(Request $request, StudentRepository $studentRepository)
    {
        return $studentRepository->index();
    }

    public function delete(Request $request, StudentRepository $studentRepository, $id)
    {
        request()->merge(['id' => $id]);
        $this->validate($request, [
            'id' => 'required|exists:students,id',
        ]);
        return $studentRepository->delete($id);
    }

    public function update(Request $request, StudentRepository $studentRepository, $id)
    {
        request()->merge(['id' => $id]);
        $this->validate($request, [
            'id' => 'required|exists:students,id',
            'nickname' => 'sometimes|required|max:20',
            'username' => 'sometimes|required|max:10',
            'desc' => 'sometimes|required|max:50',
        ]);
        $this->validate($request, [
            'username' => 'unique:students',
        ]);
        $this->validate($request, [
            'username' => 'unique:teachers',
        ]);

//        return $request->all();
        return $studentRepository->update($id, $request->only(['nickname', 'username', 'desc']));
    }
}
