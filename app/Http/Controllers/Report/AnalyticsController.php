<?php

namespace App\Http\Controllers\Report;

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
use Illuminate\Http\Request;

use App\Http\Requests;

class AnalyticsController extends Controller
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
     * Display the analytics page for the exams
     * @param Exam $exam
     * @return $this
     */
    public function index(Exam $exam)
    {
        //Check that user owns the exams
        $this->authorize('access-object', $exam);

        $students = $this->studentRepository->load_students_by_exam($exam->getId());

        $questionScores = [];
        $numberOfQuestions = count($this->questionAssignmentRepository->load_all_for_exam($exam->getId()));

        //TODO Fix this so it doesn't assume that the questions will always be numbered 1-n
        if ( $numberOfQuestions > 0 )
        {
            for ( $i = 1; $i <= $numberOfQuestions; $i++ )
            {

                /*
                 * Was getting error because this method on questionScoreRepository
                 * returns an array of stdClass objects. So updating to extract the scores from
                 * those objects
                 */
                $oneSetOfScores = [];
                $arrayOfStdObjects = $this->questionScoreRepository->load_all_for_question_number($exam->getId(), $i);
                foreach ( $arrayOfStdObjects as $obj )
                {
                    array_push($oneSetOfScores, $obj->score);
                }
                //back to what was originally here
                $questionScores[] = $oneSetOfScores;
            }
        }

        $this->scoreStatisticsRepository->loadStats($exam);
        $questionScoresByQNumber = $this->questionScoreRepository->load_all_for_exam($exam->id);
        $elementScoresByQENumber = $this->elementScoreRepository->load_all_for_exam($exam->id);

        return view('reports.exam_analytics')
            ->with([
                       'exams'                    => $exam,
                       'students'                => $students,
                       'questionScores'          => json_encode($questionScores),
                       'questionScoresByQNumber' => json_encode($questionScoresByQNumber),
                       'questionStats'           => $this->scoreStatisticsRepository->questionAssignmentStats->toJson(),
                       'elementStats'            => $this->scoreStatisticsRepository->elementAssignmentStats->toJson(),
                       'elementScoresByQENumber' => json_encode($elementScoresByQENumber),
                   ]);
    }

    function standardDeviation($array)
    {
        // square root of sum of squares divided by N-1
        return sqrt(array_sum(array_map(function ($x, $mean){
                        return pow($x - $mean, 2);
                    }, $array, array_fill(0, count($array),
                        (array_sum($array) / count($array))))) / (count($array) - 1));
    }

    // Function to calculate square of value - mean
    function sd_square($x, $mean)
    {
        return pow($x - $mean, 2);
    }

}
