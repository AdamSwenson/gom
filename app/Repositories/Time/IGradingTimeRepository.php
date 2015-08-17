<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/12/15
 * Time: 2:08 PM
 */
namespace App\Repositories\Time;

interface IGradingTimeRepository
{
    /**
     * Records or updates the time spent grading a particular student's exam
     *
     * @param $examId
     * @param $studentId
     * @param $timeToAdd
     */
    public function update($examId, $studentId, $timeToAdd);

    /**
     * Loads the time already spent grading a particular student's exam
     * @param $examId
     * @param $studentId
     */
    public function load($examId, $studentId);
}