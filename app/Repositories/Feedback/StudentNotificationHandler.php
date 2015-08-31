<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/31/15
 * Time: 11:00 AM
 */

namespace Repositories\Feedback;


class StudentNotificationHandler
{


    public function sendInitialEmailToEveryoneInClassWhoHasHadExamGraded()
    {}

    /**
     * Sends emails to everyone in class but with different
     * subject and text which indicate that something has been updated
     */
    public function sendReReleaseEmailToEveryoneInClass()
    {}


    /**
     * Should choose whether initial or second email view via a flag in the db
     * @param $student
     */
    public function sendEmailToStudent($student)
    {}



}