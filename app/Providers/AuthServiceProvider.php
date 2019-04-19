<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
//        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        Passport::tokensExpireIn(Carbon::now()->addSeconds(env('TOKEN_EXPIRE_SECONDS')));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Route::group(['middleware' => 'oauth.providers'], function () {
            Passport::routes(function ($router) {
                return $router->forAccessTokens();
            });
        });
    }
}
