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
     * Loads question and element stats for an exam
     * @param Exam $exam
     */
    public function loadStats(Exam $exam);


    /**
     * Returns collection of arrays with keys:
     * dateTime
     * totalScore
     * seconds
     * studentId (the internal db id)
     * studentIdentifier (the user assigned id)
     * studentName
     * @param Exam $exam
     * @return \Illuminate\Support\Collection
     */
    public function getScoresAndTimesByGradedOrder(Exam $exam);

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

    /**
     * Find the median for the element assignment
     *
     * @param $elementAssignmentId
     * @return float
     */
    public function getElementAssignmentMedian($elementAssignmentId);

    /**
     * Retrieves the mean for a given element assignment.
     * That is, the mean for an element on one exam.
     * @param $elementAssignmentId
     * @return null|float
     */
    public function getElementAssignmentMean($elementAssignmentId);



    /**
     * Retrieves the mean for a given question assignment.
     * That is, the mean for a question on an exam.
     *
     * @param $questionAssignmentId
     * @return null|float
     */
    public function getQuestionAssignmentMean($questionAssignmentId);

    /**
     * Find the median for the question assignment
     *
     * @param $questionAssignmentId
     * @return float
     */
    public function getQuestionAssignmentMedian($questionAssignmentId);

    /**
     * Calculates the 25th and 75th percentiles for element scores
     * @param $elementAssignmentId
     * @return array Keys quartile1 and quartile3
     */
    public function getElementAssignmentQuartiles($elementAssignmentId);
}