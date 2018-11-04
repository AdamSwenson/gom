<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 11/4/18
 * Time: 12:39 PM
 */

namespace App\Repositories\Score;


use App\Exam;

/**
 * This handles calculating statistics on scores.
 * On the first call for an exam, it will load the stats and hold them internally for subsequent calls
 * @version >=0.2.0
 * @package App\Repositories\Score
 */
interface ITotalScoreRepository
{
    /**
     * Returns just the total score for each student on the exam
     * in descending order
     *
     * Does not return any identifiable information about
     * who which score belongs to
     *
     * @param Exam $exam
     * @return array
     */
    public function getTotalScoresForExam( Exam $exam );
}