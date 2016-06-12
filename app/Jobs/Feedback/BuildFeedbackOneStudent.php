<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/13/15
 * Time: 11:54 AM
 */

namespace App\Jobs\Feedback;

use App\Events\FeedbackCompilationCompleteEvent;
use App\Events\FeedbackCompilationFailureEvent;
use App\Exam;
use App\Jobs\Job;
use App\Student;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

/**
 * Job which takes care of recompiling student feedback for one student
 *
 * @package App\Jobs\Feedback
 */
class BuildFeedbackOneStudent extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var Exam */
    public $exam;

    /** @var \App\Repositories\Feedback\IFeedbackBuilder */
    protected $feedbackBuilder;

    /** @var Student */
    protected $student;

    /** @var  integer The user's id for rehydration */
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
     * @param Student $student
     */
    public function __construct(Exam $exam, Student $student)
    {
        //make sure the user is stored for re-login on hydration
        if ( empty($this->userId) )
        {
            $this->userId = Auth::user()->id;
        }
        $this->exam = $exam;
        $this->student = $student;

        //Instantiate the class which will actually do the work
        $this->feedbackBuilder = app()->make('App\Repositories\Feedback\IFeedbackBuilder');
    }

    /**
     * Execute the build feedback job. Once done, fires a FeedbackCompilationCompleteEvent
     */
    public function handle()
    {
        /* Loading the exam and student model should be handled automatically, but it was having
        problems (perhaps related to the wake up and BaseModel issues).
        So doing it explicitly for now (and on separate line to help with debugging. */
        $exam = Exam::findOrFail($this->exam->id);
        $student = Student::findOrFail($this->student->id);

        //this solves error in feedback compilation caused by
        //inconsistent argument types
        $feedback = $this->feedbackBuilder->recompileFeedbackForStudent($exam->id, $student);

        if ( ! empty($feedback) )
        {
            //once done, fire the notification that ready for distribution
            event(new FeedbackCompilationCompleteEvent($exam));
        } else
        {
            //Error handling in case fails
            event(new FeedbackCompilationFailureEvent($exam));
        }

    }
}