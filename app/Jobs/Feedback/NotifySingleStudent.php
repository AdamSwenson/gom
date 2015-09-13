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
use Illuminate\Support\Facades\Mail;

/**
 * Carries out the task of notifying a single student that their feedback is ready
 * @package App\Jobs\Feedback
 */
class NotifySingleStudents extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $helper;
    protected $exam;
    protected $student;

    /**
     * @param Exam $exam
     * @param Student $student
     */
    public function __construct(Exam $exam, Student $student)
    {
        $this->exam = $exam;
        $this->student = $student;
        $this->helper = new NotifyStudentsHelper();
    }

    public function handle()
    {
        $this->helper->sendEmailToStudent($this->exam, $this->student);

    }
}