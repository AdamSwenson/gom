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
//        dd($this->app->environment());

        if ($this->app->environment() == 'codeceptWorld')
        {
            echo $this->app->environment();
            $this->app['config']['session.driver'] = 'native';
        }

    }
}
