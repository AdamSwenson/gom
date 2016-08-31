<?php

namespace App\Jobs\Grade;

use App\Exam;
use App\Http\Requests\GradingRequest;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Grade\IGradeAssignmentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Time\IGradingTimeRepository;
use App\Repositories\Utilities\IJsDataPreparation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class RecordScoresAndComments implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var  integer The user's id (for logging again upon hydration) */
    protected $userId;
    /**
     * @var IExamRepository
     */
    private $IExamRepository;
    /**
     * @var IElementRepository
     */
    private $elementRepository;
    /**
     * @var IElementAssignmentRepository
     */
    private $elementAssignmentRepository;
    /**
     * @var IElementScoreRepository
     */
    private $elementScoreRepository;
    /**
     * @var IQuestionAssignmentRepository
     */
    private $questionAssignmentRepository;
    /**
     * @var IQuestionScoreRepository
     */
    private $questionScoreRepository;
    /**
     * @var IGradingTimeRepository
     */
    private $gradingTimeRepository;
    /**
     * @var IStudentRepository
     */
    private $studentRepository;
    /**
     * @var IGradeAssignmentRepository
     */
    private $gradeAssignmentRepository;
    /**
     * @var IJsDataPreparation
     */
    private $jsonPrep;
    protected $dao;

    /**
     * When the object is hydrated, make sure it logs the user back in.
     * This seems to be necessary because of the way BaseModel automatically inserts
     * the user_id into the queries it uses to rehydrate the exam and Student model objects.
     */
    public function __wakeup()
    {
        Auth::loginUsingId($this->userId);
    }


    /**
     * Create a new job instance.
     *
     * @param Exam $exam
     * @param GradingRequest $request
     */
    public function __construct(Exam $exam, GradingRequest $request)
    {
        $this->exam = $exam;
        $this->request = $request;

        //make sure the user is stored for re-login on hydration
        if ( empty($this->userId) )
        {
            $this->userId = Auth::user()->id;
        }
    }

    /**
     * Execute the job.
     *
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
     * @throws \Exception
     */
    public function handle(IExamRepository $IExamRepository,
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
        $this->IExamRepository = $IExamRepository;
        $this->elementRepository = $elementRepository;
        $this->elementAssignmentRepository = $elementAssignmentRepository;
        $this->elementScoreRepository = $elementScoreRepository;
        $this->questionAssignmentRepository = $questionAssignmentRepository;
        $this->questionScoreRepository = $questionScoreRepository;
        $this->gradingTimeRepository = $gradingTimeRepository;
        $this->studentRepository = $studentRepository;
        $this->gradeAssignmentRepository = $gradeAssignmentRepository;
        $this->jsonPrep = $jsonPrep;

        //Check that user owns the exam
        $this->authorize('access-object', $this->exam);
        try
        {

            $this->recordTime($this->exam, $this->request);
            //
        } catch ( \Exception $e )
        {
            throw $e;
        }
    }


    public function recordTime(Exam $exam, GradingRequest $request)
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

    }
}