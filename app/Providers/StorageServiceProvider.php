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

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Exams
        $this->app->bind('App\Repositories\Exam\IExamRepository', 'App\Repositories\Exam\ExamRepository');

        //Elements and comments
        $this->app->bind('\App\Repositories\Element\IElementRepository', '\App\Repositories\Element\ElementRepository');
        $this->app->bind('\App\Repositories\Element\IElementAssignmentRepository', '\App\Repositories\Element\ElementAssignmentRepository');
        $this->app->bind('App\Repositories\Element\ICommentRepository', 'App\Repositories\Element\CommentRepository');

        //Feedback
        $this->app->bind('App\Repositories\Feedback\IAccessKeyRepository', 'App\Repositories\Feedback\AccessKeyRepository');
        $this->app->bind('App\Repositories\Feedback\IFeedbackBuilder', 'App\Repositories\Feedback\FeedbackBuilder');

        //Kumi (classes)
        $this->app->bind('App\Repositories\Student\IKumiRepository', 'App\Repositories\Student\KumiRepository');

        //Questions
        $this->app->bind('\App\Repositories\Question\IQuestionRepository', '\App\Repositories\Question\QuestionRepository');
        $this->app->bind('App\Repositories\Question\IQuestionAssignmentRepository', 'App\Repositories\Question\QuestionAssignmentRepository');

        //Scores
        $this->app->bind('App\Repositories\Score\IQuestionScoreRepository', 'App\Repositories\Score\QuestionScoreRepository');
        $this->app->bind('App\Repositories\Score\IElementScoreRepository', 'App\Repositories\Score\ElementScoreRepository');

        //Students
        $this->app->bind('\App\Repositories\Student\IStudentRepository', '\App\Repositories\Student\StudentRepository');
        $this->app->bind('\App\classes\SecurityClasses\cleaning\ICleanerFactory', '\App\classes\SecurityClasses\cleaning\CleanerFactory');

        $this->app->bind('App\Jobs\StudentImport\IImportStudentsFromCsv', 'App\Jobs\StudentImport\ImportStudentsFromCsv');


        //
    }
}
