<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/21/15
 * Time: 4:52 PM
 */

namespace ExamClasses\service;


interface INumberExamsManager
{

    /**
     * Sets the total number of exams in a session variable
     * @param $numExams Integer The number of exams to set
     * @return bool
     * @throws \Exception
     */
    public function set_number_exams($numExams);

    /**
     * Returns the number of exams stored in the session
     * @return bool|integer
     */
    public function get_number_exams();
}
