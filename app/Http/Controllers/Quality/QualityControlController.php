<?php

namespace App\Http\Controllers\Quality;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Feedback\IAccessKeyRepository;
use App\Repositories\Feedback\IFeedbackBuilder;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Score\IScoreStatisticsRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Time\IGradingStatsRepository;

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
     * This is for the original
     *
     * Returns the page with quality control tools for the given exam
     * @param Exam $exam
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index( Exam $exam )
    {
//        $this->featureInDevelopment();

        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $scoreStatsDao = app()->make(IScoreStatisticsRepository::class);
        $gradingTimeStatsDao = app()->make(IGradingStatsRepository::class);

        $gradingTimeStats = $gradingTimeStatsDao->get_grading_time_stats($exam->id);

        $scoresAndTimes = $scoreStatsDao->getScoresAndTimesByGradedOrder($exam);

        return view('reports.quality_control', [
            'scoresAndTimes' => $scoresAndTimes,
            //      'averageTime' => $gradingTimeStats['averageExamTime']
        ]);
    }

    /**
     * This will return the data for the quality control panel
     * in response to a get request
     *      quality/exam/{exam}
     *
     * Data includes: total exam score, grading time, graded order, grading datetime
     *
     *
     * $out = [
     * 'totalScore' => '',
     * 'gradingTime' => '',
     * 'gradedOrder' => '',
     * 'gradedDatetime' => '',
     * 'studentId' => '',
     * 'examId' => '',
     * 'kumiIds' => []
     * ];
     *
     *
     * @param Exam $exam
     * @return array
     */
    public function show( Exam $exam )
    {
        $out = [];
        //We get them by unique id since this goes through the
        //kumi table.
        $students = collect($exam->getAllAssociatedStudents())->unique('id');

        foreach ( $students as $student ) {
            try {
                $gt = $student->getGradingTimeOnExam($exam);

                // Added the isset check in GOM-415
                if ( isset($gt) ) {
                // NB, this was for the older version and will not
                // work for 0.2.0
                //if ($student->hasBeenGraded($exam->id)){
                    $out[] = [
                        'totalScore' => $student->getTotalScoreOnExam($exam),
                        'gradingTime' => $gt->seconds,
                        'gradedOrder' => '',
                        'gradedDatetime' => $gt->updated_at,
                        'studentId' => $student->id,
                        'examId' => $exam->id,
                        'kumiIds' => []
                    ];
                }
            } catch (\Exception $e) {
//                var_dump($e);
            }
        }

        return $out;

    }


}
