<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;

Route::get('/', function () {
    User::create([
        'name' => 'usera',
        'email' => 'a@a.com',
        'password' => bcrypt('a@a.com')
    ]);
    return view('welcome');
});