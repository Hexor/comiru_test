<?php

namespace App\Repositories;

use App\Student;
use App\Teacher;
use App\LineUser;
use App\TeacherStudent;
use App\Jobs\PushLineMessage;

class TeacherStudentRepository extends Repository
{
    public function create($studentID = null)
    {
        if ($studentID) {
            return Teacher::with('followed')->get();
        } else {
            return Teacher::all();
        }
    }

    /**
     * @param $teacher_id
     * @param $student
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function switchFollowStatus($teacher_id, $student)
    {
        $followed = TeacherStudent::where('teacher_id', $teacher_id)->where('student_id', $student->id)->first();
        $pushMessagePrefix = '学员 ' . $student->nickname . ' ';
        if ($followed) {
            if (true === $followed->delete()) {
                $this->pushFollowNotification($teacher_id, $pushMessagePrefix . '刚刚取消关注你了。');
                return responseSuccess(['follows_status' => 'unfollowing']);
            }
        } else {
            $followed = new TeacherStudent([
                'teacher_id' => $teacher_id,
                'student_id' => $student->id]);
            $saved = $followed->save();
            if ($saved) {
                $this->pushFollowNotification($teacher_id, $pushMessagePrefix . '刚刚关注你了。');
                return responseSuccess(['follows_status' => 'following']);
            }
        }
        throwSaveFailedException('关注操作失败');
        return null;
    }

    public function pushFollowNotification($teacherID, $message)
    {
        $line = LineUser::where('teacher_id', $teacherID)->first();
        if ($line) {
            PushLineMessage::dispatch([
                'to' => $line->getOriginal()['id'],
                'body' => $message
            ]);
        }
    }

    public function index()
    {
        $keyword = request()->get('keyword');
        $relateTeacherIDs = Teacher::where('username', 'like', "%{$keyword}%")->pluck('id')->toArray();
        $relateStudentIDs = Student::where('username', 'like', "%{$keyword}%")->pluck('id')->toArray();

        $data = $this->getSearchAbleData(
            TeacherStudent::class,
            [],
            function ($builder) use ($relateStudentIDs, $relateTeacherIDs) {
                if (!empty($relateStudentIDs)) {
                    $builder->orWhereIn('student_id', $relateStudentIDs);
                }
                if (!empty($relateTeacherIDs)) {
                    $builder->orWhereIn('teacher_id', $relateTeacherIDs);
                }
                $builder->with('student')->with('teacher');
            },
            function ($buses) {
//                foreach ($buses as $bus) {
//                }
            }
        );


        return $data;
    }

    public function delete($id)
    {
        try {
            $deletedRows = TeacherStudent::where('id', $id)->delete();
            if (1 !== $deletedRows) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            return responseError('删除失败', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return responseSuccess();
    }
}
