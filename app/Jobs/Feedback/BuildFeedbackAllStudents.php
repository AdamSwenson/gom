<?php

namespace App\Jobs\Feedback;

use App\Events\FeedbackCompilationCompleteEvent;
use App\Events\FeedbackCompilationFailureEvent;
use App\Exam;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

/**
 * Job which takes care of compiling student feedback for all graded students
 *
 * @package App\Jobs\Feedback
 */
class BuildFeedbackAllStudents extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var Exam  */
    public $exam;

    /** @var \App\Repositories\Feedback\IFeedbackBuilder */
    protected $feedbackBuilder;

    /** @var integer Holds for rehydration */
    protected $userId;

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
     * @param Exam $exam
     */
    public function __construct(Exam $exam)
    {
        //make sure the user is stored for re-login on hydration
        if (empty($this->userId))
        {
            $this->userId = Auth::user()->id;
        }
        $this->exam = $exam;

        //Instantiate the class which will actually do the work
        $this->feedbackBuilder = app()->make('App\Repositories\Feedback\IFeedbackBuilder');
    }

    /**
     * Execute the build feedback job. Once done, fires a FeedbackCompilationCompleteEvent
     */
    public function handle()
    {
        /* Loading the exam model should be handled automatically, but it was having
        problems (perhaps related to the wakeup and BaseModel issues).
        So doing it explicitly for now (and on separate line to help with debugging. */
        $exam = Exam::findOrFail($this->exam->id);
        $feedback = $this->feedbackBuilder->buildFeedback($exam->id);
        if(!empty($feedback))
        {
            //once done, fire the notification that ready for distribution
            event(new FeedbackCompilationCompleteEvent($exam));
        }
        else
        {
            //Error handling in case fails
            event(new FeedbackCompilationFailureEvent($exam));
        }
    }


}
