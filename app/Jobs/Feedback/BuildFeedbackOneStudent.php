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
use App\Repositories\Feedback\IFeedbackBuilder;
use App\Student;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


/**
 * Job which takes care of recompiling student feedback for one student
 *
 * @package App\Jobs\Feedback
 */
class BuildFeedbackOneStudent extends Job implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var Exam */
    public $exam;

    /** @var \App\Repositories\Feedback\IFeedbackBuilder */
    protected $feedbackBuilder;

    /** @var Student */
    protected $student;

    /** @var  integer The user's id for rehydration */
    protected $userId;
    protected $examId;
    protected $studentId;

    /**
     * When the object is hydrated, make sure it logs the user back in.
     * This seems to be necessary because of the way BaseModel automatically inserts
     * the user_id into the queries it uses to rehydrate the exam and Student model objects.
     */
    public function __wakeup()
    {
//        if( ! Auth::check() ){
//            Auth::loginUsingId($this->userId);
//        }
//
//        //Instantiate the class which will actually do the work
//        $this->feedbackBuilder = app()->make(IFeedbackBuilder::class);
     //   $this->exam = Exam::find($this->examId);
      //  $this->student = Student::find($this->studentId);
    }

    /**
     * Create a new job instance.
     * @param Exam $exam
     * @param Student $student
     */
    public function __construct(Exam $exam, Student $student)
    {
       //   Log::info('construct' . $exam->id . $student->id);
        //make sure the user is stored for re-login on hydration
        if ( empty($this->userId) )
        {
            $this->userId = Auth::user()->id;
        }
        $this->examId = $exam->id;
        $this->studentId = $student->id;
    }

    /**
     * Execute the build feedback job. Once done, fires a FeedbackCompilationCompleteEvent
     *
     */
    public function handle()
    {

        //Instantiate the class which will actually do the work
        $this->feedbackBuilder = app()->make(IFeedbackBuilder::class);
        Log::info('handling build feedback one student');

        /* Loading the exam and student model should be handled automatically, but it was having
        problems (perhaps related to the wake up and BaseModel issues).
        So doing it explicitly for now (and on separate line to help with debugging. */
        $exam = Exam::findOrFail($this->examId);
        $student = Student::findOrFail($this->studentId);

        //this solves error in feedback compilation caused by
        //inconsistent argument types
        $feedback = $this->feedbackBuilder->recompileFeedbackForStudent($exam->id, $student);

        if ( ! empty($feedback) )
        {
            //once done, fire the notification that ready for distribution
            event(new FeedbackCompilationCompleteEvent($exam, $student));
        } else
        {
            //Error handling in case fails
            event(new FeedbackCompilationFailureEvent($exam));
        }

    }
}