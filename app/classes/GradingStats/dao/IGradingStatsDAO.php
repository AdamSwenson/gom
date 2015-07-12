<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/21/15
 * Time: 5:36 PM
 */

namespace GradingStats\dao;


interface IGradingStatsDAO
{

    /**
     * Gets the pages divided by time of the past exams
     * @param  int   $limit
     * @return array
     */
    public function getPagesPerMinute($limit);

    public function getCalcluatedTimeStats();

    /**
     * Calculates the percentage complete
     * @return array Associative array with keys examsGraded, examsUngraded, pctComplete
     */
    public function getPercentageComplete();
}