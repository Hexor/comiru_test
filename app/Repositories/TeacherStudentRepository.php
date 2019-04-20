<?php

namespace App\Repositories;

use App\Teacher;
use App\LineUser;
use App\TeacherStudent;
use App\Jobs\PushLineMessage;

class TeacherStudentRepository
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
        return TeacherStudent::with('student')->get();
    }
}
