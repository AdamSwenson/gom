<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/16
 * Time: 2:50 PM
 */
namespace App\Repositories\Utilities;


/**
 * Does the work of sending emails.
 * This is abstracted away from the various jobs which use it
 * mostly to help with testing.
 *
 * @package App\Repositories\Utilities
 */
interface IMailSender
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
    public function send($to_address, $to_name, $data, $emailView, $subject);
}