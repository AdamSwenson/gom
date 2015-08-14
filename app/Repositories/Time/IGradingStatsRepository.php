<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/13/15
 * Time: 5:44 PM
 */
namespace App\Repositories\Time;


/**
 * Class GradingStatsRepository
 *
 * Handles statistics on grading time
 *
 * @package Repositories\Time
 */
interface IGradingStatsRepository
{
    /**
     * Calculates statistics for grading time.
     *
     * Returns an array with the following keys:
     *      averageExamTime: (float) The average time in seconds spent on each exam
     *      gradeTimeElapsed: (float) The time in seconds spent so far grading the current set of exams
     *      gradeTimeRemaining: (float) The estimate time in seconds it will take to finish grading
     *      remainingExams: (int) The number of exams which have not yet been graded
     *      totalExams: (int) The total number of exams to grade
     *
     * @param integer $examId
     * @return array
     */
    public function get_grading_time_stats($examId);
}