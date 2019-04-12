<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:teacher')->get('/teacher', function (Request $request) {
    Auth::guard('teacher')->user()->token()->revoke();

    return $request->user();
});

Route::middleware('auth:student')->get('/student', function (Request $request) {
//    Auth::guard('student')->user()->token()->revoke();

    return $request->user();
});

Route::post('login', function (Request $request) {

    // Fire off the internal request.

    $proxy = Request::create('/oauth/token', 'POST',[
            'username' => $request->username,
            'password' => $request->password,
            'grant_type' => 'password',
            'client_id' => 2,
            'provider' => $request->provider,
            'client_secret' => 'NysNLZOqvScGz8UaVdTibcTamTPzsorEhfki5kRx',
            'scope' => '*'
    ]);


    return app()->handle($proxy);

});