<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/22/15
 * Time: 3:51 PM
 */
namespace App\Jobs\Feedback;

use App\Events\StudentNotificationCompleteEvent;
use App\Exam;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class NotifyAllStudents extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var \App\Jobs\Feedback\INotifyStudentsHelper */
    protected $helper;

    /** @var Exam */
    protected $exam;

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
     */
    public function __construct(Exam $exam)
    {
        //make sure the user is stored for re-login on hydration
        if (empty($this->userId))
        {
            $this->userId = Auth::user()->id;
        }
        $this->exam = $exam;
        //Load helper which actually does the sending
        $this->helper = app()->make('App\Jobs\Feedback\INotifyStudentsHelper');
    }

    /**
     * Send emails to every graded student. Then trigger a StudentNotificationCompleteEvent to
     * signal that the emails have been sent.
     */
    public function handle()
    {
        /* Loading the exam model should be handled automatically, but it was having
        problems (perhaps related to the wakeup and BaseModel issues).
        So doing it explicitly for now. */
        $exam = Exam::findOrFail($this->exam->id);
        $this->helper->sendEmailToAllGradedStudents($exam);

        //Signal that the emails have been sent (or, more correctly, been pushed to mailgun)
        event(new StudentNotificationCompleteEvent());
    }
}