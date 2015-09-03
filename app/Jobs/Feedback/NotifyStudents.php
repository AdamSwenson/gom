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

class NotifyStudents extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    const INITIAL_EMAIL_VIEW = 'feedback.initial_student_notification';
    const SECOND_EMAIL_VIEW = 'feedback.additional_student_notification';

    /**
     * Sends a notification email with link to feedback to all students whose exams
     * have been graded. Uses database flags to determine which version of the email to send.
     *
     * @param Exam $exam
     */
    public function sendEmailToAllGradedStudents(Exam $exam)
    {
        /*
        //check whether already sent, if not
        $this->sendInitialEmailToEveryone($exam);
        //if already sent
        $this->sendEmailToAllGradedStudents($exam);
    */
    }

    /**
     * Should choose whether initial or second email view via a flag in the db
     * @param $student
     */
    public function sendEmailToStudent(Student $student)
    {
    }


    /**
     * Sends a notification email with link to feedback to all students whose exams
     * have been graded.
     *
     * @param Exam $exam
     */
    protected function sendInitialEmailToEveryone(Exam $exam)
    {
    }

    /**
     * Sends emails to everyone in class but with different
     * subject and text which indicate that something has been updated.
     *
     * @param Exam $exam
     */
    protected function sendReReleaseEmailToEveryone(Exam $exam)
    {
        //get all students
        $students = [];
        foreach($students as $s)
        {

        }

    }

    protected function send($to_address, $to_name, $contentArray, $emailView, $subject)
    {
        Mail::queue($emailView, $contentArray, function ($message) use ($to_address, $to_name, $subject)
        {
            $message->to($to_address, $to_name)->subject($subject);
        });
    }
}