<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Events\ExamReleasedEvent;
use App\Exam;
use App\Jobs\Feedback\BuildFeedbackAllStudents;
use App\Jobs\Feedback\BuildFeedbackOneStudent;
use App\Jobs\Feedback\NotifyAllStudents;
use App\Jobs\Feedback\NotifySingleStudent;
use App\Repositories\Score\IScoreStatisticsRepository;
use App\Student;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Feedback\IAccessKeyRepository;
use App\Repositories\Feedback\IFeedbackBuilder;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;

use Illuminate\Support\Facades\Auth;

/**
 * Class QualityControlController
 * @package App\Http\Controllers\Report
 */
class QualityControlController extends Controller
{

    /** @var IElementScoreRepository */
    protected $elementScoreRepository;
    /** @var IAccessKeyRepository */
    protected $accessKeyDao;
    /** @var IFeedbackBuilder */
    protected $feedbackBuilder;
    /** @var IQuestionAssignmentRepository */
    protected $questionAssignmentRepository;
    /** @var IElementAssignmentRepository */
    protected $elementAssignmentRepository;
    /** @var IQuestionScoreRepository */
    protected $questionScoreRepository;
    /** @var ICommentRepository */
    protected $commentRepository;
    /** @var IStudentRepository */
    protected $studentRepository;
    /** @var IExamRepository */
    protected $examDao;
    /** @var IScoreStatisticsRepository */
    protected $scoreStatisticsRepository;

    /**
     * @param IAccessKeyRepository $accessKeyRepository
     * @param IExamRepository $examRepository
     * @param IFeedbackBuilder $feedbackBuilder
     * @param IStudentRepository $studentRepository
     * @param IQuestionAssignmentRepository $questionAssignmentRepository
     * @param IElementAssignmentRepository $elementAssignmentRepository
     * @param IQuestionScoreRepository $questionScoreRepository
     * @param IElementScoreRepository $elementScoreRepository
     * @param ICommentRepository $commentRepository
     * @param IStudentRepository $studentRepository
     * @param IScoreStatisticsRepository $scoreStatisticsRepository
     * @internal param IScoreStatisticsRepository $IScoreStatisticsRepository
     */
    public function __construct(
        IAccessKeyRepository $accessKeyRepository,
        IExamRepository $examRepository,
        IFeedbackBuilder $feedbackBuilder,
        IStudentRepository $studentRepository,
        IQuestionAssignmentRepository $questionAssignmentRepository,
        IElementAssignmentRepository $elementAssignmentRepository,
        IQuestionScoreRepository $questionScoreRepository,
        IElementScoreRepository $elementScoreRepository,
        ICommentRepository $commentRepository,
        IScoreStatisticsRepository $scoreStatisticsRepository
    )
    {
        $this->middleware('auth');
        $this->accessKeyDao = $accessKeyRepository;
        $this->examDao = $examRepository;
        $this->feedbackBuilder = $feedbackBuilder;
        $this->questionAssignmentRepository = $questionAssignmentRepository;
        $this->elementAssignmentRepository = $elementAssignmentRepository;
        $this->questionScoreRepository = $questionScoreRepository;
        $this->elementScoreRepository = $elementScoreRepository;
        $this->commentRepository = $commentRepository;
        $this->studentRepository = $studentRepository;
        $this->scoreStatisticsRepository = $scoreStatisticsRepository;
    }

    /**
     * Returns the page with quality control tools for the given exam
     * @param Exam $exam
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Exam $exam)
    {
//        $this->featureInDevelopment();

        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $scoreStatsDao = app()->make('App\Repositories\Score\IScoreStatisticsRepository');
        $gradingTimeStatsDao = app()->make('App\Repositories\Time\IGradingStatsRepository');

        $gradingTimeStats = $gradingTimeStatsDao->get_grading_time_stats($exam->id);

        $scoresAndTimes = $scoreStatsDao->getScoresAndTimesByGradedOrder($exam);

        return view('reports.quality_control', [
            'scoresAndTimes' => $scoresAndTimes,
            //      'averageTime' => $gradingTimeStats['averageExamTime']
        ]);
    }

    //
}
