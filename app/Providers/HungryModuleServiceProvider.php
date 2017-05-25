<?php

namespace App\Providers;

// use Classes\HungryModule;
use Illuminate\Support\ServiceProvider;

class HungryModuleServiceProvider extends ServiceProvider
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
        \App::bind('hungrymodule', function()
        {
            return new \App\Classes\HungryModule;
        });
        // $this->app->singleton(HungryModule::class, function ($app) {
        //     return new Connection(config('hungrymodule'));
        // });
    }
}
