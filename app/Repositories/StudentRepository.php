<?php

namespace App\Repositories;

use App\Student;
use App\LineUser;
use App\TeacherStudent;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class StudentRepository extends Repository
{
    public function index($teacherID = null)
    {
        if ($teacherID) {
            return TeacherStudent::where('teacher_id', $teacherID)->with('student')->get();
        } else {
            return $this->all();
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $deletedRows = Student::where('id', $id)->delete();
            if (1 !== $deletedRows) {
                throw new \Exception();
            }
            TeacherStudent::where('student_id', $id)->delete();
            LineUser::where('student_id', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return responseError('删除失败', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return responseSuccess();
    }

    public function update($id, $content)
    {
        $student = Student::whereId($id)->firstOrFail();
        $saved = $student->update($content);
        if (!$saved) {
            throwSaveFailedException();
        }
        return $student;
    }

    private function all()
    {
        $data = $this->getSearchAbleData(Student::class, ['id','nickname', 'username'], function ($builder) {
        }, function ($buses) {
            foreach ($buses as $bus) {
            }
        });

        return $data;
    }
}
