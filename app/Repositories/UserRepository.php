<?php

namespace App\Repositories;

use App\Student;
use App\Teacher;

class UserRepository
{
    public function getUserByUsername($username, $signType)
    {
        $model = $this->getUserModel($signType);

        return $model::where('username', $username)->first();
    }

    public function getUserByID($id, $signType)
    {
        $model = $this->getUserModel($signType);
        return $model::find($id);
    }

    /**
     * @param $signType
     * @return string
     */
    public function getUserModel($signType)
    {
        $model = Teacher::class;
        if ($signType === 'student') {
            $model = Student::class;
        }
        return $model;
    }
}
