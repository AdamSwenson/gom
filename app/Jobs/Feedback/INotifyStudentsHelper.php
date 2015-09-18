<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/13/15
 * Time: 11:05 AM
 */
namespace App\Jobs\Feedback;

use App\Exam;
use App\Student;


/**
 * Does all the work (loads access key, constructs feedback link, looks up email addresses,
 * and sends the message) for any job which notifies students that feedback is ready.
 *
 * @package App\Jobs\Feedback
 */
interface INotifyStudentsHelper
{
    /**
     * Sends a notification email with link to feedback to all students whose exams
     * have been graded. Uses database flags to determine which version of the email to send.
     *
     * @param Exam $exam
     */
    public function sendEmailToAllGradedStudents(Exam $exam);

    /**
     * Prepares and sends a notification email to one student.
     * The $initial parameter governs whether to send the initial email or a re-notification email.
     * @param Exam $exam
     * @param Student $student
     * @param bool|true $initial Whether to send the initial email
     */
    public function sendEmailToStudent(Exam $exam, Student $student, $initial = true);
}