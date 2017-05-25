<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthGatewayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('authgateway', function()
        {
            return new \App\Classes\AuthGateway;
        });
    }
}
