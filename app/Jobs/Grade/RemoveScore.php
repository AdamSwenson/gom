<?php

namespace App\Jobs\Grade;

use App\Events\AsyncJobCompleteEvent;
use App\Exam;
use App\Http\Requests\Request;
use App\Jobs\Job;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class RemoveScore extends Job implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected $questionAssignmentId;
    protected $examId;
    protected $elementId;
    protected $studentId;
    protected $userId;
    protected $dao;
    protected $elementAssignmentDao;
    protected $elementAssignmentRepository;


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
     * @param Exam $exam
     * @param Request $request
     */
    public function __construct(Exam $exam, Request $request)
    {
        $this->examId = $exam->id;
        $this->elementId = $request->has('element_id') ? $request->input('element_id') : null;
        $this->studentId = $request->has('student_id') ? $request->input('student_id') : null;
        $this->questionAssignmentId = $request->has('question_assignment_id') ? $request->input('question_assignment_id') : null;

        //make sure the user is stored for re-login on hydration
        if ( empty($this->userId) )
        {
            $this->userId = Auth::user()->id;
        }
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try
        {
            //Don't even get started if there's no student id
            if ( ! $this->studentId )
            {
                throw new \Exception('No student id set in grade request');
            }

            if ( $this->questionAssignmentId )
            {
                $this->dao = app()->make(IQuestionScoreRepository::class);

                $this->dao->deleteScore($this->questionAssignmentId, $this->studentId);
            }

            // at this point, this isn't used as there is no means to reset an element score to ungraded.
            // Since the grade page doesn't store element assignment info, the element id must be used.
            if ( $this->elementId )
            {
                $this->elementAssignmentDao = app()->make(IElementAssignmentRepository::class);

                $this->dao = app()->make(IElementScoreRepository::class);

                $eAssignid = $this->elementAssignmentDao->load_element_assignment_by_element($this->examId, $this->elementId);

                $this->dao->deleteScore($eAssignid, $this->studentId);
            }

            event(new AsyncJobCompleteEvent($this, true));

        } catch ( \Exception $e )
        {
            event(new AsyncJobCompleteEvent($this, false));
            throw $e;
        }

    }

}
