<?php

namespace App\Providers;

use App\Http\Controllers\helpers\assignments\AssignmentHelper;
use App\Http\Controllers\helpers\assignments\IAssignmentHelper;
use App\HTTP\Controllers\helpers\cleaning\CleanerFactory;
use App\HTTP\Controllers\helpers\cleaning\ICleanerFactory;
use App\Http\Controllers\helpers\validation\IStudentRecordValidator;
use App\Http\Controllers\helpers\validation\StudentRecordValidator;
use App\Http\Controllers\Report\ReportController;
use App\Jobs\Export\ExportScores;
use App\Jobs\Feedback\INotifyStudentsHelper;
use App\Jobs\Feedback\NotifyStudentsHelper;
use App\Jobs\Grade\RecordScoresAndComments;
use App\Jobs\StudentImport\IImportStudentsFromCsv;
use App\Jobs\StudentImport\ImportStudentsFromCsv;
use App\Repositories\Assignment\AssignmentRepository;
use App\Repositories\Assignment\IAssignmentRepository;
use App\Repositories\Element\CommentRepository;
use App\Repositories\Element\ElementAssignmentRepository;
use App\Repositories\Element\ElementRepository;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Exam\INewExamRepository;
use App\Repositories\Exam\NewExamRepository;
use App\Repositories\Item\IItemCommentRepository;
use App\Repositories\Item\IItemScoreStatisticsRepository;
use App\Repositories\Item\ItemCommentRepository;
use App\Repositories\Exam\ExamRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Exam\INumberGradedRepository;
use App\Repositories\Exam\IStoredExamStatsRepository;
use App\Repositories\Exam\NumberGradedRepository;
use App\Repositories\Exam\StoredExamStatsRepository;
use App\Repositories\Feedback\AccessKeyRepository;
use App\Repositories\Feedback\FeedbackBuilder;
use App\Repositories\Feedback\IAccessKeyRepository;
use App\Repositories\Feedback\IFeedbackBuilder;
use App\Repositories\Grade\GradeAssignmentRepository;
use App\Repositories\Grade\IGradeAssignmentRepository;
use App\Repositories\Grade\StudentGradeRepository;
use App\Repositories\Item\IItemRepository;
use App\Repositories\Item\ItemRepository;
use App\Repositories\Item\ItemScoreStatisticsRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Question\QuestionAssignmentRepository;
use App\Repositories\Question\QuestionRepository;
use App\Repositories\Question\QuestionsForExamGenerator;
use App\Repositories\Score\ElementScoreRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Score\IScoreStatisticsRepository;
use App\Repositories\Score\ITotalScoreRepository;
use App\Repositories\Score\QuestionScoreRepository;
use App\Repositories\Score\ScoreStatisticsRepository;
use App\Repositories\Score\TotalScoreRepository;
use App\Repositories\Student\IKumiRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Student\KumiRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Student\StudentsForExamGenerator;
use App\Repositories\Time\GradingStatsRepository;
use App\Repositories\Time\GradingTimeRepository;
use App\Repositories\Time\IGradingStatsRepository;
use App\Repositories\Time\IGradingTimeRepository;
use App\Repositories\Utilities\BackupFlagRepository;
use App\Repositories\Utilities\IBackupFlagRepository;
use App\Repositories\Utilities\IJsDataPreparation;
use App\Repositories\Utilities\IMailSender;
use App\Repositories\Utilities\JsDataPreparation;
use App\Repositories\Utilities\MailSender;
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
        $this->app->bind(IExamRepository::class,
            ExamRepository::class);

        //Elements and comments
        $this->app->bind(IElementRepository::class,
            ElementRepository::class);
        $this->app->bind(IElementAssignmentRepository::class,
            ElementAssignmentRepository::class);
        $this->app->bind(ICommentRepository::class,
            CommentRepository::class);

        //Feedback
        $this->app->bind(IAccessKeyRepository::class,
            AccessKeyRepository::class);
        $this->app->bind(IFeedbackBuilder::class,
            FeedbackBuilder::class);

        //Grade and grade assignments
        $this->app->bind(IGradeAssignmentRepository::class,
            GradeAssignmentRepository::class);
        $this->app->bind(IStudentGradeRepository::class,
            StudentGradeRepository::class);

        //Item
        $this->app->bind(IItemRepository::class,
            ItemRepository::class);

        //Kumi (classes)
        $this->app->bind(IKumiRepository::class,
            KumiRepository::class);

        //Questions
        $this->app->bind(IQuestionRepository::class,
            QuestionRepository::class);
        $this->app->bind(IQuestionAssignmentRepository::class,
            QuestionAssignmentRepository::class);

        //Scores
        $this->app->bind(IQuestionScoreRepository::class,
            QuestionScoreRepository::class);
        $this->app->bind(IElementScoreRepository::class,
            ElementScoreRepository::class);
        $this->app->bind(ITotalScoreRepository::class,
            TotalScoreRepository::class);

        //Stats
        $this->app->bind(IScoreStatisticsRepository::class,
            ScoreStatisticsRepository::class);
        $this->app->bind(IItemScoreStatisticsRepository::class,
            ItemScoreStatisticsRepository::class);

        //Students
        $this->app->bind(IStudentRepository::class,
            StudentRepository::class);

        //Time
        $this->app->bind(IGradingTimeRepository::class,
            GradingTimeRepository::class);
        $this->app->bind(IGradingStatsRepository::class,
            GradingStatsRepository::class);


        /* ------------------------------------------------ Jobs -----------------------------------------------------*/
        //Students
        $this->app->bind(IImportStudentsFromCsv::class,
            ImportStudentsFromCsv::class);

        //Email notifications
        $this->app->bind(INotifyStudentsHelper::class,
            NotifyStudentsHelper::class);
        //Backup
        $this->app->bind(ExportScores::class,
            ExportScores::class);
        //Scores
        $this->app->bind(RecordScoresAndComments::class,
            RecordScoresAndComments::class);

        /* ------------------------------------------------ Tools ----------------------------------------------------- */
        $this->app->bind(ICleanerFactory::class,
            CleanerFactory::class);

        $this->app->bind(IAssignmentHelper::class,
            AssignmentHelper::class);

        $this->app->bind(IStudentRecordValidator::class,
            StudentRecordValidator::class);

        /* -------------------------------------------------- Generators ----------------------------------------------- */
        $this->app->bind(QuestionsForExamGenerator::class,
            QuestionsForExamGenerator::class);
        $this->app->bind(StudentsForExamGenerator::class,
            StudentsForExamGenerator::class);


        /* -------------------------------------------------- Other ---------------------------------------------------- */
        //yes. dumb. i know.
        $this->app->bind(ReportController::class,
            ReportController::class);

        $this->app->bind(INumberGradedRepository::class,
            NumberGradedRepository::class);
        $this->app->bind(IStoredExamStatsRepository::class,
            StoredExamStatsRepository::class);

        $this->app->bind(IBackupFlagRepository::class,
            BackupFlagRepository::class);


        $this->app->bind(IMailSender::class,
            MailSender::class);

        $this->app->bind(IJsDataPreparation::class,
            JsDataPreparation::class);

        /* ########################### >= VERSION 2.0.0 ########## */

        //new setup
        $this->app->bind(IAssignmentRepository::class,
            AssignmentRepository::class);
        $this->app->bind(IItemCommentRepository::class, ItemCommentRepository::class);

        $this->app->bind(INewExamRepository::class, NewExamRepository::class);
    }
}
