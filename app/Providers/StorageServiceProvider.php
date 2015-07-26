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
        $this->app->bind('\App\Repositories\Question\IQuestionRepository', '\App\Repositories\Question\QuestionRepository');
        $this->app->bind('\App\Repositories\Question\IQuestionAssignmentRepository', '\App\Repositories\Question\QuestionAssignmentRepository');

        $this->app->bind('\App\Repositories\Element\IElementRepository', '\App\Repositories\Element\ElementRepository');
        $this->app->bind('\App\Repositories\Element\IElementAssignmentRepository', '\App\Repositories\Element\ElementAssignmentRepository');

        $this->app->bind('\App\Repositories\Student\IStudentRepository', '\App\Repositories\Student\StudentRepository');

        $this->app->bind('\App\classes\SecurityClasses\cleaning\ICleanerFactory', '\App\classes\SecurityClasses\cleaning\CleanerFactory');
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
