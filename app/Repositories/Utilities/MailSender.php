<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/16
 * Time: 2:48 PM
 */

namespace App\Repositories\Utilities;


/**
 * Does the work of sending emails.
 * This is abstracted away from the various jobs which use it
 * mostly to help with testing.
 *
 * @package App\Repositories\Utilities
 */
class MailSender implements IMailSender
{


    /**
     * Actually sends the email to the student.
     *
     * @param string $to_address Recipient's email address
     * @param string $to_name Recipient's name
     * @param array $data Data to be passed to the view
     * @param string $emailView Which email text to use
     * @param string $subject Subject line of the email
     */
    public function send($to_address, $to_name, $data, $emailView, $subject)
    {
        \Mail::send($emailView, $data, function ($message) use ($to_address, $to_name, $subject)
        {
            $message->to($to_address, $to_name)->subject($subject);
        });
    }


    /**
     * Updates the db flags to show that the student has had the email sent.
     * Adds entry to the mail log
     *
     * @param Exam $exam
     * @param Student $student
     */
    public function logSent(Exam $exam, Student $student)
    {
        // TODO: Set up mail logging
    }



}