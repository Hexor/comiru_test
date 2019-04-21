<?php

namespace App\Repositories;

use App\LineUser;
use App\Teacher;
use App\TeacherStudent;
use Illuminate\Support\Facades\DB;

class TeacherRepository extends Repository
{
    public function index($studentID = null)
    {
        if ($studentID) {
            return Teacher::with('followed')->get();
        } else {
            return $this->all();
        }
    }

    public function create()
    {
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $deletedRows = Teacher::where('id', $id)->delete();
            if (1 !== $deletedRows) {
                throw new \Exception();
            }
            TeacherStudent::where('teacher_id', $id)->delete();
            LineUser::where('teacher_id', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return responseError('删除失败', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return responseSuccess();
    }

    private function all()
    {
        $data = $this->getSearchAbleData(Teacher::class, ['id', 'nickname', 'username'], function ($builder) {
        }, function ($buses) {
            foreach ($buses as $bus) {
            }
        });

        return $data;
    }
}
