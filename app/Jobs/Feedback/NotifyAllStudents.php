<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/22/15
 * Time: 3:51 PM
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

class NotifyAllStudents extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $helper;
protected $exam;
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
        $this->helper = new NotifyStudentsHelper();
    }

    public function handle()
    {
        $this->helper->sendEmailToAllGradedStudents($this->exam);

    }
}