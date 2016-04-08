<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TestingServiceProvider extends ServiceProvider
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

        if ($this->app->environment() == 'codeceptWorld')
        {
            //echo 'environment is: ' . $this->app->environment() . '\n';
            $this->app['config']['session.driver'] = 'native';
        }

    }
}
