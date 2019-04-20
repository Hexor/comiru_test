<?php

namespace App\Repositories;

use App\Student;
use App\TeacherStudent;
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
        $deletedRows = Student::where('id', $id)->delete();
        if (1 === $deletedRows) {
            return responseSuccess();
        } else {
            return responseError('删除失败', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update($id, $content)
    {
        $student = Student::whereId($id)->firstOrFail();
        $saved = $student->fill($content)->save();
        if (!$saved) {
            throwSaveFailedException();
        }
        return $student;
    }

    private function all()
    {
        $data = $this->getSearchAbleData(Student::class, ['nickname', 'username'], function ($builder) {
        }, function ($buses) {
            foreach ($buses as $bus) {
            }
        });

        return $data;
    }
}
