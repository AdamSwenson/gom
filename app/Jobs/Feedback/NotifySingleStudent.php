<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/12/15
 * Time: 6:46 PM
 */

namespace App\Jobs\Feedback;

use App\Exam;
use App\Jobs\Job;
use App\Student;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

/**
 * Carries out the task of notifying a single student that their feedback is ready.
 *
 * @package App\Jobs\Feedback
 */
class NotifySingleStudent extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var Exam  */
    protected $exam;

    /** @var \App\Jobs\Feedback\INotifyStudentsHelper */
    protected $helper;

    /** @var Student  */
    protected $student;

    /** @var  integer The user's id (for logging again upon hydration) */
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
     * @param Exam $exam
     * @param Student $student
     */
    public function __construct(Exam $exam, Student $student)
    {
        //make sure the user is stored for re-login on hydration
        if( empty($this->userId) )
        {
            $this->userId = Auth::user()->id;
        }
        $this->exam = $exam;
        $this->student = $student;

        //Load the worker which handles all the sending
        $this->helper = app()->make('App\Jobs\Feedback\INotifyStudentsHelper');
    }

    /**
     * Sends a notification email to the student
     */
    public function handle()
    {
        /* Loading the exam and student models should be handled automatically, but it was having
        problems (perhaps related to the wakeup and BaseModel issues).
        So doing it explicitly for now.
        Putting them on different lines (rather than as parameters to help with debugging */
        $exam = Exam::findOrFail($this->exam->id);
        $student = Student::findOrFail($this->student->id);

        //Do the sending
        $this->helper->sendEmailToStudent($exam, $student);
    }
}