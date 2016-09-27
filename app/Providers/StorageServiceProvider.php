<?php

namespace App\Providers;

use App\Jobs\Grade\RecordScoresAndComments;
use App\Repositories\Utilities\IJsDataPreparation;
use App\Repositories\Utilities\JsDataPreparation;
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
        /* ---------------------------------------------- Repositories ---------------------------------------------- */
        //Exams
        $this->app->bind('App\Repositories\Exam\IExamRepository', 'App\Repositories\Exam\ExamRepository');

        //Elements and comments
        $this->app->bind('App\Repositories\Element\IElementRepository', 'App\Repositories\Element\ElementRepository');
        $this->app->bind('App\Repositories\Element\IElementAssignmentRepository', 'App\Repositories\Element\ElementAssignmentRepository');
        $this->app->bind('App\Repositories\Element\ICommentRepository', 'App\Repositories\Element\CommentRepository');

        //Feedback
        $this->app->bind('App\Repositories\Feedback\IAccessKeyRepository', 'App\Repositories\Feedback\AccessKeyRepository');
        $this->app->bind('App\Repositories\Feedback\IFeedbackBuilder', 'App\Repositories\Feedback\FeedbackBuilder');

        //Grade and grade assignments
        $this->app->bind('App\Repositories\Grade\IGradeAssignmentRepository', 'App\Repositories\Grade\GradeAssignmentRepository');
        $this->app->bind('App\Repositories\Grade\IStudentGradeRepository', 'App\Repositories\Grade\StudentGradeRepository');

        //Kumi (classes)
        $this->app->bind('App\Repositories\Student\IKumiRepository', 'App\Repositories\Student\KumiRepository');

        //Questions
        $this->app->bind('App\Repositories\Question\IQuestionRepository', 'App\Repositories\Question\QuestionRepository');
        $this->app->bind('App\Repositories\Question\IQuestionAssignmentRepository', 'App\Repositories\Question\QuestionAssignmentRepository');

        //Scores
        $this->app->bind('App\Repositories\Score\IQuestionScoreRepository', 'App\Repositories\Score\QuestionScoreRepository');
        $this->app->bind('App\Repositories\Score\IElementScoreRepository', 'App\Repositories\Score\ElementScoreRepository');

        //Stats
        $this->app->bind('App\Repositories\Score\IScoreStatisticsRepository', 'App\Repositories\Score\ScoreStatisticsRepository');

        //Students
        $this->app->bind('App\Repositories\Student\IStudentRepository', 'App\Repositories\Student\StudentRepository');

        //Time
        $this->app->bind('App\Repositories\Time\IGradingTimeRepository', 'App\Repositories\Time\GradingTimeRepository');
        $this->app->bind('App\Repositories\Time\IGradingStatsRepository', 'App\Repositories\Time\GradingStatsRepository');


        /* ------------------------------------------------ Jobs -----------------------------------------------------*/
        //Students
        $this->app->bind('App\Jobs\StudentImport\IImportStudentsFromCsv', 'App\Jobs\StudentImport\ImportStudentsFromCsv');
        //Email notifications
        $this->app->bind('App\Jobs\Feedback\INotifyStudentsHelper', 'App\Jobs\Feedback\NotifyStudentsHelper');
        //Backup
        $this->app->bind('ExportScores', '\App\Jobs\Export\ExportScores');
        //Scores
        $this->app->bind(RecordScoresAndComments::class, RecordScoresAndComments::class);

        /* ------------------------------------------------ Tools ----------------------------------------------------- */
        $this->app->bind('App\HTTP\Controllers\helpers\cleaning\ICleanerFactory', 'App\HTTP\Controllers\helpers\cleaning\CleanerFactory');

        $this->app->bind('App\Http\Controllers\helpers\assignments\IAssignmentHelper', 'App\Http\Controllers\helpers\assignments\AssignmentHelper');

        $this->app->bind('App\Http\Controllers\helpers\validation\IStudentRecordValidator', 'App\Http\Controllers\helpers\validation\StudentRecordValidator');

        /* -------------------------------------------------- Generators ----------------------------------------------- */
        $this->app->bind('QuestionsForExamGenerator', 'App\Repositories\Question\QuestionsForExamGenerator');
        $this->app->bind('StudentsForExamGenerator', '\App\Repositories\Student\StudentsForExamGenerator');


        /* -------------------------------------------------- Other ---------------------------------------------------- */
        //yes. dumb. i know.
        $this->app->bind('App\HTTP\Controllers\ReportController', 'App\HTTP\Controllers\ReportController');

        $this->app->bind('App\Repositories\Exam\INumberGradedRepository', 'App\Repositories\Exam\NumberGradedRepository');
        $this->app->bind('App\Repositories\Exam\IStoredExamStatsRepository', 'App\Repositories\Exam\StoredExamStatsRepository');

        $this->app->bind('App\Repositories\Utilities\IBackupFlagRepository', 'App\Repositories\Utilities\BackupFlagRepository');


        $this->app->bind('App\Repositories\Utilities\IMailSender', 'App\Repositories\Utilities\MailSender');

        $this->app->bind(IJsDataPreparation::class, JsDataPreparation::class);
    }
}
