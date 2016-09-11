<?php

namespace App\Jobs\Grade;

use App\Exam;
use App\Student;

use App\Events\Ajax\PleaseSendAjaxFail;
use App\Events\Ajax\PleaseSendAjaxSuccess;

use App\Http\Requests\GradingRequest;
use App\Jobs\Feedback\BuildFeedbackOneStudent;

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


use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class RecordScoresAndComments implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, DispatchesJobs;

    /** @var  integer The user's id (for logging again upon hydration) */
    protected $userId;
    protected $exam;
    protected $request;
    protected $questionAssignmentId;
    protected $elementId;
    protected $studentId;
    protected $commentText;
    protected $score;
    protected $examId;
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
        if ( ! Auth::check() )
        {
            Auth::loginUsingId($this->userId);
        }

    }


    /**
     * Create a new job instance.
     *
     * @param Exam $exam
     * @param GradingRequest $request
     */
    public function __construct(Exam $exam, $request)
    {
        $this->examId = $exam->id;
        $this->elementId = $request->has('element_id') ? $request->input('element_id') : null;
        $this->studentId = $request->has('student_id') ? $request->input('student_id') : null;
        $this->questionAssignmentId = $request->has('question_assignment_id') ? $request->input('question_assignment_id') : null;
        $this->commentText = $request->has('comment_text') ? $request->input('comment_text') : null;
        $this->score = $request->has('score') ? $request->input('score') : null;

        //make sure the user is stored for re-login on hydration
        if ( empty($this->userId) )
        {
            $this->userId = Auth::user()->id;
        }
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     */
    public function handle()
    {

        $this->exam = Exam::find($this->examId);

        //Check that user owns the exam
//        $this->authorize('access-object', $this->exam);
        try
        {

            //Don't even get started if there's no student id
            if ( empty($this->studentId) )
            {
                throw new Exception('No student id set in grade request');
            }

            //If the request is to record a question score, it follows this path
            if ( ! empty($this->questionAssignmentId) && ! empty($this->score) )
            {
                $this->recordQuestion();
                event(new PleaseSendAjaxSuccess(self::class));
            }

            //If it is to record an element score, it follows this path
            if ( ! empty($this->elementId) )
            {
                $this->recordElement();
                event(new PleaseSendAjaxSuccess(self::class));
            }

            // Check if the exam has been released.
            // A released exam will need to have its compiled feedback updated for this student
            if ( $this->exam->getReleased() )
            {
                $student = Student::findOrFail($this->studentId);
                $job = new BuildFeedbackOneStudent($this->exam, $student);
                $this->dispatch($job);
            }



//                $this->dao = app()->make(IElementScoreRepository::class);
//                //item is an element assignment. this is its id
//                $itemId = $this->elementAssignmentRepository
//                    ->load_element_assignment_by_element($this->exam->getId(), $this->elementId)
//                    ->getId();
//
//                // if an element has comment text with it, record it.
//                if ( ! empty($this->commentText) )
//                {
//                    $this->dao->recordCommentText($itemId, $this->studentId, $this->commentText);
//                }


            // record score fot the question or element
//            if ( ! empty($this->score) )
//            {
//                // if the score returns as 'NaN' that item's score has been removed, so delete from DB
//                $score = $this->score;
//                if ( $score == NAN )
//                {
//                    //todo Decide whether to re-enable this (it is handled on a separate route)
//                    //$this->dao->deleteScore
//                } else
//                {
//                    $this->dao->record($itemId, $this->studentId, $score);
//                }
//            }
//
//
        } catch ( Exception $e )
        {
            event(new PleaseSendAjaxFail(self::class));

            throw $e;
        }
    }

    public function recordElement()
    {
        $this->elementAssignmentRepository = app()->make(IElementAssignmentRepository::class);
        $this->dao = app()->make(IElementScoreRepository::class);

        //item is an element assignment. this is its id
        $itemId = $this->elementAssignmentRepository
            ->load_element_assignment_by_element($this->exam->getId(), $this->elementId)
            ->getId();
        // record score fot the question or element
        if ( ! empty($this->score) )
        {
            $this->dao->record($itemId, $this->studentId, $this->score);
        }

        // if an element has comment text with it, record it.
        if ( ! empty($this->commentText) )
        {
            $this->dao->recordCommentText($itemId, $this->studentId, $this->commentText);
        }

    }

    public function recordQuestion()
    {
        $this->dao = app()->make(IQuestionScoreRepository::class);
        $this->dao->record($this->questionAssignmentId, $this->studentId, $this->score);
    }
}