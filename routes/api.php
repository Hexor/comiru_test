<?php

use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('st', function (Request $request) {
    $teacher = Teacher::find(1);

    $token = $teacher->createToken('My Token');
    return $token;
//    $tokens = $teacher->tokens();
//    foreach ($tokens as $token) {
//        $token->revoke();
//    }
    return $teacher->tokens();
});

Route::group([
    'prefix' => 'line',
    'middleware' => ['line-auth']
], function () {
    Route::get('line_users', 'LineUserController@index')->name('get_line_users_from_line_auth');
});

$StudentTeacherCommonRoutes = function ($tokenProvider) {
    request()->merge(['token_provider' => $tokenProvider]);
    Route::get('/', function (Request $request) {
        return $request->user();
    });
    Route::get('line_users', 'LineUserController@index');
    Route::post('bind_line', 'AuthController@bindLine')->middleware('line-auth');
};


Route::group([
    'prefix' => 'student',
    'middleware' => ['auth:student']
], function () use ($StudentTeacherCommonRoutes) {
    $StudentTeacherCommonRoutes('students');
});


Route::group([
    'prefix' => 'teacher',
    'middleware' => ['auth:teacher']
], function () use ($StudentTeacherCommonRoutes) {
    $StudentTeacherCommonRoutes('teachers');
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('signup', 'AuthController@signup');
    Route::post('signin', 'AuthController@signin');
});


Route::any('line_auth_callback', 'AuthController@lineAuthCallback');
//http://127.0.0.1/api/line_auth_callback?code=BGXbp6CUwV2ipygGz6UW&state=12345abcde

//https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1564192144&redirect_uri=http://127.0.0.1:8000/api/line_auth_callback&state=12345&scope=openid

