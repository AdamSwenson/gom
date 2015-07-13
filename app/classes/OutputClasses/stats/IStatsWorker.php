<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 6:13 PM
 */

namespace App\classes\OutputClasses\stats;


interface IStatsWorker 
{
    public function get_scores(\Exam $exam, $item);

    public function get_items(\Exam $exam);

    /**
     * @param \App\classes\ScoreClasses\dao\ScoreDAO $score_dao
     */
    public function setScoreDao($score_dao);


}