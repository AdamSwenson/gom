<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class StorageServiceProvider
 *
 * Handles the registration of the database layer.
 * Basically, the classes which do the work of the earlier xxxxDAO classes
 * should be registered here.
 *
 *
 * @package App\Providers
 */
class StorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('\App\Repositories\Exam\IExamRepository', '\App\Repositories\Exam\ExamRepository');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
