<?php

namespace App\Repositories;


use App\Exceptions\ApiException;
use App\LineUser;
use App\Student;
use App\Teacher;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class LineUserRepository
{

    public function create($lineID, $tokenProvider, $user)
    {
        $lineUser = $this->isExistLineUser($lineID, $tokenProvider, $user);
        if ($lineUser) {
            return $lineUser;
        }


        $data = [
            'id' => $lineID,
        ];
        if ($tokenProvider === 'teachers') {
            $data['teacher_id'] = $user->id;
        } elseif ($tokenProvider === 'users') {
            $data['user_id'] = $user->id;
        }


        $lineUser = new LineUser($data);
        $saved = $lineUser->save();
        if ($saved) {
            return $lineUser;
        } else {
            throwSaveFailedException('无法存储数据, 绑定失败');
        }
    }


    /**
     * @param $lineID
     * @param $tokenProvider
     * @param $user
     * @return mixed 如果存在, 则返回相应模型, 否则返回 null
     * @throws Exception
     */
    private function isExistLineUser($lineID, $tokenProvider, $user)
    {
        $where = [
            ['id', '=', $lineID],
        ];

        if ($tokenProvider === 'teachers') {
            $exist = LineUser::where($where)->whereNotNull('teacher_id')->first();
            if (!empty($exist) && $exist->teacher_id != $user->id) {
                // 该帐号已经绑定了其他的教师帐号
                throw new Exception("该 Line 用户已经绑定了其他教师帐号, 绑定失败", Response::HTTP_CONFLICT);
            }
            return $exist;
        } elseif ($tokenProvider === 'students') {
            $where[] = ['student_id', '=', $user->id];
            return LineUser::where($where)->first();
        }
    }

    public function indexByLineID($id)
    {
        $teacher = LineUser::where([
            ['id', '=', $id]
        ])->whereNotNull('teacher_id')->with('teacher')->first();

        $students = LineUser::where('id', $id)->whereNotNull('student_id')->with('student')->get();

        $result = [];
        foreach ($students as $student) {
            $result[] = $student;
        }
        if ($teacher) {
            $result[] = $teacher;
        }

        return $result;
    }

    public function index()
    {
        $request = request();
        $user = $request->user();
        $request->token_provider;

        $queryColomn = '';
        if ($request->token_provider === 'teachers') {
            $queryColomn = 'teacher_id';
        } elseif ($request->token_provider === 'students') {
            $queryColomn = 'student_id';
        }

        $result = LineUser::where($queryColomn, $user->id)->first();
        if (!$result) {
            return;
        }

        return $this->indexByLineID($result->id);

    }

    public function isUserBindLine($username)
    {
        try {
            if (request()->signup_type === 'teacher') {
                $teacher = Teacher::where('username', $username)->firstOrFail();
                LineUser::where('teacher_id', $teacher->id)->firstOrFail();
            }

            if (request()->signup_type === 'student') {
                $student = Student::where('username', $username)->firstOrFail();
                LineUser::where('student_id', $student->id)->firstOrFail();
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

}