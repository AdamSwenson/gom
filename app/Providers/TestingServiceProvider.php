<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
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
        if ( $this->app->environment() == 'codeceptWorld' )
        {
            //set the session driver to prevent weirdness
            $this->app['config']['session.driver'] = 'native';

            //use the testing database
            $this->app['config']['database.connections.mysql.database'] = 'gom_testing';
            $this->app['config']['queue.default'] = 'sync';
            Log::info('running codeception. environment is: ' . $this->app->environment());

            Log::info("db is: " . env('DB_DATABASE'));
        }

    }
}
