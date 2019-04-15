<?php

use App\Teacher;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use League\OAuth2\Server\AuthorizationServer;

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
//    Auth::guard('teacher')->user()->token()->revoke();

    return $request->user();
});

Route::middleware('auth:student')->get('/student', function (Request $request) {
//    Auth::guard('student')->user()->token()->revoke();

    return $request->user();
});

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
    'prefix' => 'auth'
], function () {
//    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

//    Route::group([
//        'middleware' => 'auth:api'
//    ], function() {
//        Route::get('logout', 'AuthController@logout');
//        Route::get('user', 'AuthController@user');
//    });

    Route::post('signin', function (Request $request) {

        // Fire off the internal request.

        $proxy = Request::create('/oauth/token', 'POST', [
            'username' => $request->username,
            'password' => $request->password,
            'grant_type' => 'password',
            'client_id' => 2,
            'provider' => $request->provider,
            'client_secret' => 'NoEtJmKV5sUUScA5AosfTjiu050vNBpZJNn4PPNc',
            'scope' => '*'
        ]);


        return app()->handle($proxy);

    });

});

//http://127.0.0.1/api/line_auth_callback?code=BGXbp6CUwV2ipygGz6UW&state=12345abcde

//https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1564192144&redirect_uri=http://127.0.0.1:8000/api/line_auth_callback&state=12345&scope=openid

Route::any('line_auth_callback', function (Request $request) {

    if ($request->state != '12345') {
        return 'error 1';
    }

    $http = new GuzzleHttp\Client();
    $jwt = $http->post('https://api.line.me/oauth2/v2.1/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '1564192144',
            'client_secret' => 'e98e2ae3f3ec2dc9291f6885731746eb',
            'redirect_uri' => 'http://127.0.0.1:8000/api/line_auth_callback',
            'code' => $request->code,
        ],
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]
    ]);


// line 返回的加密后的用户信息
//  "access_token" => "eyJhb......"
//  "token_type" => "Bearer"
//  "refresh_token" => "GR87P4JaLfKqJcXSMgID...."
//  "expires_in" => 2592000
//  "scope" => "openid"
//  "id_token" => "eyJ0eXAiOiJKcyCI"

    $encodedDataFromLineServer = json_decode($jwt->getBody()->getContents(), true);
    dd($encodedDataFromLineServer);

//   解密 id_token 后得到用户的 line信息
//    +"iss": "https://access.line.me"  make sure
//    +"sub": "U57f93ee27d38ec9077cedb50059ef4c2" User ID for which the ID token is generated
//    +"aud": "1564192144" make sure it is your channel id
//    +"exp": 1555057940 make sure current time is not larger than exp (1小时过期)
//    +"iat": 1555054340 Time when the ID token was generated in UNIX time.
    $decoded = JWT::decode($encodedDataFromLineServer['id_token'], 'e98e2ae3f3ec2dc9291f6885731746eb', ['HS256']);
    dd($decoded);
});
