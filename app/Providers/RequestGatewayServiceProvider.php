<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RequestGatewayServiceProvider extends ServiceProvider
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
        \App::bind('requestgateway', function()
        {
            return new \App\Classes\RequestGateway;
        });
    }
}
