<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use \Carbon\Carbon;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::useClientModel('App\PassportClient');
    }

    public function boot()
    {
    	Passport::tokensExpireIn(Carbon::now()->addHours(1));
	    Passport::refreshTokensExpireIn(Carbon::now()->addHours(2));
	    Passport::personalAccessTokensExpireIn(Carbon::now()->addMonths(1));
    }
}
