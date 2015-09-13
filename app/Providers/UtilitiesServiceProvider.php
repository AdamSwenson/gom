<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class UtilitiesServiceProvider
 *
 * This handles management and registration of various tools
 * like cleaners.
 *
 * @package App\Providers
 */
class UtilitiesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       // $this->app->bind('\App\classes\SecurityClasses\cleaning\ICleanerFactory', '\App\classes\SecurityClasses\cleaning\CleanerFactory');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind('\App\classes\SecurityClasses\cleaning\ICleanerFactory', '\App\classes\SecurityClasses\cleaning\CleanerFactory');
        //
    }
}
