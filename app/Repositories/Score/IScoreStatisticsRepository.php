<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/13/15
 * Time: 2:51 PM
 */
namespace App\Repositories\Score;

use App\Exam;


/**
 * This handles calculating statistics on scores.
 * On the first call for an exam, it will load the stats and hold them internally for subsequent calls
 *
 * @package App\Repositories\Score
 */
interface IScoreStatisticsRepository
{
    /**
     * Returns an array of statistical information or the specified value
     * @param Exam $exam
     * @param $question_assignment_id
     * @param null $returnValueOf
     * @return float|\Illuminate\Support\Collection|null
     */
    public function getStatsForQuestionAssignment(Exam $exam, $question_assignment_id, $returnValueOf = null);

    /**
     * Returns an array of statistical information or the specified value
     * @param Exam $exam
     * @param $element_assignment_id
     * @param null $returnValueOf
     * @return \Illuminate\Support\Collection|float|null
     */
    public function getStatsForElementAssignment(Exam $exam, $element_assignment_id, $returnValueOf = null);
}