<?php

namespace App\Repositories;

use Exception;
use App\Student;
use App\Teacher;
use App\LineUser;
use Symfony\Component\HttpFoundation\Response;

class LineUserRepository extends Repository
{
    /**
     * @param $lineID
     * @param $tokenProvider
     * @param $user
     * @return LineUser|mixed
     * @throws Exception
     */
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
            $this->makeSureOnlyOneTeacherCanBindLine($user->id, $lineID);
            $data['teacher_id'] = $user->id;
        } elseif ($tokenProvider === 'students') {
            $data['student_id'] = $user->id;
        }


        $lineUser = new LineUser($data);
        $saved = $lineUser->save();
        if ($saved) {
            return $lineUser;
        } else {
            throwSaveFailedException('无法存储数据, 绑定失败');
        }
        return null;
    }

    public function indexByLineID($id)
    {
        $teacher = LineUser::where([
            ['id', '=', $id]
        ])->whereNotNull('teacher_id')->with('teacher')->first();

        $students = LineUser::where('id', $id)->whereNotNull('student_id')->with('student')->get();

        $result = [];
        if ($teacher) {
            $result[] = $teacher;
        }

        foreach ($students as $student) {
            $result[] = $student;
        }

        return $result;
    }

    public function index()
    {
        $request = request();
        $user = $request->user();

        $queryColomn = '';
        if ($user->sign_type === 'teacher') {
            $queryColomn = 'teacher_id';
        } elseif ($user->sign_type === 'student') {
            $queryColomn = 'student_id';
        }

        $result = LineUser::where($queryColomn, $user->id)->first();
        if (!$result) {
            return null;
        }

        return $this->indexByLineID($result->getOriginal()['id']);
    }

    public function isUserBindLine($username, $signType)
    {
        $lineUser = null;
        try {
            if ($signType === 'teacher') {
                $teacher = Teacher::where('username', $username)->firstOrFail();
                $lineUser = LineUser::where('teacher_id', $teacher->id)->firstOrFail();
                $lineUser->user = $teacher;
            } elseif ($signType === 'student') {
                $student = Student::where('username', $username)->firstOrFail();
                $lineUser = LineUser::where('student_id', $student->id)->firstOrFail();
                $lineUser->user = $student;
            }
        } catch (Exception $e) {
            return null;
        }

        return $lineUser;
    }

    /**
     * @param $teacherID
     * @param $lineID
     * @throws Exception
     */
    public function makeSureOnlyOneTeacherCanBindLine($teacherID, $lineID)
    {
        $exist = LineUser::where('id', $lineID)->whereNotNull('teacher_id')->first();
        if ($exist) {
            if ($exist->teacher_id !== $teacherID) {
                throw new Exception('一个Line 帐号只能绑定一个教师帐号, 绑定失败', Response::HTTP_CONFLICT);
            }
        }
    }

    public function findByUser($user)
    {
        return LineUser::where($user->sign_type . '_id', $user->id)->first();
    }

    public function findByID($lineID)
    {
        return LineUser::where('id', $lineID)->first();
    }

    public function all()
    {
        $keyword = request()->get('keyword');
        $relateTeacherIDs = Teacher::where('username', 'like', "%{$keyword}%")->pluck('id')->toArray();
        $relateStudentIDs = Student::where('username', 'like', "%{$keyword}%")->pluck('id')->toArray();

        $data = $this->getSearchAbleData(
            LineUser::class,
            ['id'],
            function ($builder) use ($relateStudentIDs, $relateTeacherIDs) {
                if (!empty($relateStudentIDs)) {
                    $builder->orWhereIn('student_id', $relateStudentIDs);
                }
                if (!empty($relateTeacherIDs)) {
                    $builder->orWhereIn('teacher_id', $relateTeacherIDs);
                }
                $builder->with('student')->with('teacher');
            },
            function ($items) {
                foreach ($items as $item) {
                    $item->username = $this->getUsernameDesc($item);
                }
            }
        );


        return $data;
    }

    public function getUsernameDesc($lineUser)
    {
        if (!empty($lineUser->student)) {
            return '[学员] ' . $lineUser->student->username;
        }
        if (!empty($lineUser->teacher)) {
            return '[教师] ' . $lineUser->teacher->username;
        }
    }

    public function delete($userID, $column)
    {
        try {
            $deletedRows = LineUser::where($column, $userID)->delete();
            if (1 !== $deletedRows) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            return responseError('删除失败', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return responseSuccess();
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
        return null;
    }
}
