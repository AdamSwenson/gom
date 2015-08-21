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
     * Adds an interval in seconds to the time spent grading a particular student's exam or
     * creates a new entry if no time has been recorded.
     *
     * @param integer $examId
     * @param integer $studentId
     * @param float $timeToAdd
     */
    public function update($examId, $studentId, $timeToAdd);

    /**
     * Loads the time already spent grading a particular student's exam
     * @param $examId
     * @param $studentId
     */
    public function load($examId, $studentId);

    /**
     * Records a total grading time in the database. If a time already exists for the student, this will overwrite it.
     * If you instead want to add the time to the preexisting time, use GradingTimeRepository::update()
     *
     * @param integer $examId
     * @param integer $studentId
     * @param float $totalGradingTime
     */
    public function record($examId, $studentId, $totalGradingTime);
}