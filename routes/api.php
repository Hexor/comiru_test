<?php

use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('teachers', 'TeacherController@relatedIndex')->middleware('auth:student');
Route::get('students', 'StudentController@relatedIndex')->middleware('auth:teacher');

Route::group([
    'prefix' => 'line',
    'middleware' => ['line-auth']
], function () {
    Route::get('line_users', 'LineUserController@index')->name('get_line_users_from_line_auth');
    Route::post('bind_user', 'LineUserController@bindUser');
    Route::post('switch_user', 'LineUserController@switchUser');
});

$StudentTeacherCommonRoutes = function ($tokenProvider, $controllerName) {
    request()->merge(['token_provider' => $tokenProvider]);
    Route::get('/', function (Request $request) {
        return $request->user();
    });
    Route::get('line_users', 'LineUserController@index');
    Route::post('bind_line', $controllerName . '@bindLine')->middleware('line-auth');
    Route::post('bind_user', $controllerName . '@bindUser');
    Route::post('switch_user', $controllerName . '@switchUser');
};


Route::group([
    'prefix' => 'student',
    'middleware' => ['auth:student']
], function () use ($StudentTeacherCommonRoutes) {
    $StudentTeacherCommonRoutes('students', 'StudentController');
    Route::post('follow_teacher', 'TeacherStudentController@handleFollow');
});


Route::group([
    'prefix' => 'teacher',
    'middleware' => ['auth:teacher']
], function () use ($StudentTeacherCommonRoutes) {
    $StudentTeacherCommonRoutes('teachers', 'TeacherController');
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('signup', 'AuthController@signup');
    Route::post('signin', 'AuthController@signin');
});

Route::group([
    'prefix' => 'admin'
], function () {
    Route::post('signin', 'AuthController@adminSignin');
    Route::post('signup', 'AuthController@adminSignup');

    Route::group([
        'middleware' => ['admin-auth']
    ], function () {
        Route::get('me', 'AdminController@me');

        Route::get('students', 'StudentController@adminIndex');
        Route::delete('students/{id}', 'StudentController@delete');
        Route::patch('students/{id}', 'StudentController@update');

        Route::get('teachers', 'TeacherController@adminIndex');
        Route::delete('teachers/{id}', 'TeacherController@delete');
        Route::post('teachers', 'TeacherController@store');

        Route::get('teacher_students', 'TeacherStudentController@adminIndex');
        Route::delete('teacher_students/{id}', 'TeacherStudentController@delete');

        Route::get('line_users', 'LineUserController@adminIndex');
        Route::delete('line_users/teacher/{id}', 'LineUserController@deleteTeacher');
        Route::delete('line_users/student/{id}', 'LineUserController@deleteStudent');
    });
});

Route::any('line_auth_callback', 'AuthController@lineAuthCallback');
//http://127.0.0.1/api/line_auth_callback?code=BGXbp6CUwV2ipygGz6UW&state=12345abcde
//https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1564192144&redirect_uri=http://127.0.0.1:8000/api/line_auth_callback&state=12345&scope=openid


// 以下是测试用的路由
Route::get('st', function (Request $request) {
    $teacher = Teacher::find(1);

    $token = $teacher->createToken('My Token');
    return $token;
//    $tokens = $teacher->tokens();
//    foreach ($tokens as $token) {
//        $token->revoke();
//    }
//    return $teacher->tokens();
});

Route::get('push', 'AuthController@push');
