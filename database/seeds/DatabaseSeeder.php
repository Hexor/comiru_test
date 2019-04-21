<?php

use App\Student;
use App\Teacher;
use App\TeacherStudent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $username = substr($faker->unique()->userName, 0, 10);
            if (!Student::where('username', $username)->first()) {
                Student::create([
                    'username' => $username,
                    'nickname' => $faker->name,
                    'password' => bcrypt('comiru'),
                ]);
            }
        }
        for ($i = 0; $i < 10; $i++) {
            $username = substr($faker->unique()->userName, 0, 10);
            if (!Teacher::where('username', $username)->first()) {
                Teacher::create([
                    'username' => $username,
                    'nickname' => $faker->name,
                    'password' => bcrypt('comiru'),
                ]);
            }
        }

        $teacherIDs = Teacher::where('id', '>', 1)->pluck('id')->toArray();

        $students = Student::all();
        foreach ($students as $student) {
            $studentID = $student->id;
            $teacherID = $teacherIDs[rand(0, count($teacherIDs) - 1)];
            if (!TeacherStudent::where([
                ['teacher_id', '=', $teacherID],
                ['student_id', '=', $studentID],
            ])->first()) {
                $followed = new TeacherStudent([
                    'teacher_id' => $teacherID,
                    'student_id' => $studentID]);
                $saved = $followed->save();
            }
        }
    }
}
