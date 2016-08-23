<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Comment;
use App\Http\Requests\GradeAssignmentRequest;
use App\Http\Requests\GradingRequest;

use App\Exam;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Jobs\AsyncStorage\UpdateAllStoredNumGraded;
use App\Jobs\AsyncStorage\UpdateStoredExamStats;
use App\Jobs\AsyncStorage\UpdateStoredNumGraded;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Grade\GradeFactory;
use App\Repositories\Grade\IGradeAssignmentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Time\IGradingTimeRepository;

use App\Repositories\Utilities\IJsDataPreparation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use JavaScript;

/**
 * Class ScoreController
 *
 * This handles all api requests having to do with question scores,
 * element scores, or comments.
 *
 * @package App\Http\Controllers\Api
 */
class ScoreController extends Controller
{
    //

    const INVALID_GRADE_ASSIGNMENT_MESSAGE = 'The criteria you entered were inconsistent.';

    const GRADE_ASSIGNMENT_FIELD_BASE = 'gradeGroup';

    /** If there is no max score set in the database, use this */
    const DEFAULT_MAX_QUESTION_SCORE = 20;

    /** @var  IExamRepository */
    protected $examDao;

    /** @var  IQuestionAssignmentRepository */
    protected $questionAssignmentDao;

    /** @var  IElementRepository */
    protected $elementDao;

    /** @var  IElementAssignmentRepository */
    protected $elementAssignmentDao;

    /** @var  IElementScoreRepository */
    protected $elementScoreDao;

    /** @var  IQuestionScoreRepository */
    protected $questionScoreDao;

    /** @var  IGradingTimeRepository */
    protected $gradingTimeDao;

    /** @var  IGradeAssignmentRepository */
    protected $gradeAssignmentDao;

    protected $dao;

    protected $reportController;

    /** @var IStudentRepository */
    protected $studentDao;
    /**
     * @var IJsDataPreparation
     */
    private $jsonPrep;

    /**
     * @param IExamRepository $IExamRepository
     * @param IElementRepository $elementRepository
     * @param IElementAssignmentRepository $elementAssignmentRepository
     * @param IElementScoreRepository $elementScoreRepository
     * @param IQuestionAssignmentRepository $questionAssignmentRepository
     * @param IQuestionScoreRepository $questionScoreRepository
     * @param IGradingTimeRepository $gradingTimeRepository
     * @param IStudentRepository $studentRepository
     * @param IGradeAssignmentRepository $gradeAssignmentRepository
     * @param IJsDataPreparation $jsonPrep
     */
    public function __construct(IExamRepository $IExamRepository,
                                IElementRepository $elementRepository,
                                IElementAssignmentRepository $elementAssignmentRepository,
                                IElementScoreRepository $elementScoreRepository,
                                IQuestionAssignmentRepository $questionAssignmentRepository,
                                IQuestionScoreRepository $questionScoreRepository,
                                IGradingTimeRepository $gradingTimeRepository,
                                IStudentRepository $studentRepository,
                                IGradeAssignmentRepository $gradeAssignmentRepository,
                                IJsDataPreparation $jsonPrep)
    {
        $this->middleware('auth');
        $this->examDao = $IExamRepository;
        $this->questionAssignmentDao = $questionAssignmentRepository;
        $this->elementDao = $elementRepository;
        $this->elementAssignmentDao = $elementAssignmentRepository;
        $this->elementScoreDao = $elementScoreRepository;
        $this->questionScoreDao = $questionScoreRepository;
        $this->gradingTimeDao = $gradingTimeRepository;
        $this->studentDao = $studentRepository;
        $this->gradeAssignmentDao = $gradeAssignmentRepository;
        $this->jsonPrep = $jsonPrep;
    }

    /**
     * Records scores, comments and grade time
     * @param Exam $exam
     * @param GradingRequest $request
     * @return Response json
     * @throws \Exception
     */
    public function recordScore(Exam $exam, GradingRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);
        try
        {
            //Don't even get started if there's no student id
            if ( ! $request->has('student_id') )
            {
                throw new \Exception('No student id set in grade request');
            }

            $studentId = $request->input('student_id');

            $itemId = null;

            //If the request is to record a question score, it follows this path
            if ( $request->has('question_assignment_id') )
            {
                $this->dao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
                $itemId = $request->input('question_assignment_id');
            }
            //If it is to record an element score, it follows this path
            if ( $request->has('element_id') )
            {
                $this->dao = app()->make('App\Repositories\Score\IElementScoreRepository');
                $itemId = $this->elementAssignmentDao->load_element_assignment_by_element($exam->getId(),
                                                                                          $request->input('element_id'))->getId();

                // if a comment has text with it, record that as well.
                if ( $request->exists('comment_text') )
                {
                    $this->dao->recordCommentText($itemId, $studentId, $request->input('comment_text'));
                }
            }

            // record score fot the question or comment
            if ( $request->exists('score') )
            {
                // if the score returns as 'NaN' that item's score has been removed, so delete from DB
                $score = $request->input('score');
                if ( $score == NAN )
                {
                    //$this->dao->deleteScore
                } else
                {
                    $this->dao->record($itemId, $studentId, $score);
                }
            }

            // Check if the exam has been released.
            // A released exam will have its compiled feedback updated  for this student
            if ( $exam->getReleased() )
            {
                $reportController = app()->make('App\Http\Controllers\Report\ReportController');
                $reportController->updateFeedbackForStudent($exam, $studentId);
            }

            $this->recordTime($exam, $request);

            $this->dispatch(new UpdateStoredNumGraded($exam));

            return $this->sendAjaxSuccess();

        } catch ( \Exception $e )
        {
            throw $e;

            return $this->sendAjaxFailure();

        }
    }


    /**
     * Removes a question or element score when it has been deleted.
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function removeScore(Exam $exam, GradingRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);
        try
        {
            //Don't even get started if there's no student id
            if ( ! $request->has('student_id') )
            {
                throw new \Exception('No student id set in grade request');
            }

            $studentId = $request->input('student_id');

            if ( $request->has('question_assignment_id') )
            {
                $this->questionScoreDao->deleteScore($request['question_assignment_id'], $studentId);
            }

            // at this point, this isn't used as there is no means to reset an element score to ungraded.
            // Since the grade page doesn't store element assignment info, the element id must be used.
            if ( $request->has('element_id') )
            {
                $eAssignid = $this->elementAssignmentDao->load_element_assignment_by_element($exam->getId(), $request['element_assignment_id']);
                $this->elementScoreDao->deleteScore($eAssignid, $studentId);
            }

            return $this->sendAjaxSuccess();

        } catch ( \Exception $e )
        {
            throw $e;

            return $this->sendAjaxFailure();
        }
    }


    /**
     * Record or add to the time spent grade a particular student's exam
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     */
    public function recordTime(Exam $exam, GradingRequest $request)
    {

    //    return redirect()->action('Api\TimeController@recordTime');
        //->with(['exam' => $exam, 'request' => $request]);


        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        if ( $request->has('student_id') && $request->has('time') )
        {
            $dao = app()->make('App\Repositories\Time\IGradingTimeRepository');
            $time = $dao->record($exam->getId(), $request->input('student_id'), $request->input('time'));

            return $time;
        }
    }
}