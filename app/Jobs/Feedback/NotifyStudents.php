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

class NotifyStudents extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;


    /**
     * Sends a notification email with link to feedback to all students whose exams
     * have been graded.
     *
     * @param Exam $exam
     */
    public function sendInitialEmailToEveryone(Exam $exam)
    {}

    /**
     * Sends emails to everyone in class but with different
     * subject and text which indicate that something has been updated.
     *
     * @param Exam $exam
     */
    public function sendReReleaseEmailToEveryone(Exam $exam)
    {}


    /**
     * Should choose whether initial or second email view via a flag in the db
     * @param $student
     */
    public function sendEmailToStudent(Student $student)
    {}
}