<?php

namespace App\classes\OutputClasses\stats;

use Map\ElementScoresTableMap;
use App\classes\OutputClasses\stats\IStatsWorker;
use Propel\Runtime\Formatter\ObjectFormatter;
use Propel\Runtime\Propel;


/**
 * Calculates the average score on each element for all students taking the exam
 *
 * @todo Rewrite to call a stored procedure
 * @author adam
 */
class ElementStats implements IStatsWorker
{
    public $avg_key = 'elementAverage';
    public $id_key = 'elementID';

    /** @var  \App\classes\ScoreClasses\dao\ScoreDAO */
    public $score_dao;

    /**
     * @param \App\classes\ScoreClasses\dao\ScoreDAO $score_dao
     */
    public function setScoreDao($score_dao)
    {
        $this->score_dao = $score_dao;
    }


    public function get_scores(\Exam $exam, $item)
    {
        $scores = array();
        $this->score_dao->setExam($exam);
        $es = $this->score_dao->load('element', $item);

//        $es = \ElementScoreQuery::create()->filterByExam($exam)->filterByElement($item)->find();
        foreach($es as $e){
            array_push($scores, $e->getElementscore());
        }
        return $scores;
    }

    public function get_items(\Exam $exam)
    {
        $elements = array();
        $element_assigns = \ElementAssignmentQuery::create()
            ->filterByExam($exam)
            ->find();
        foreach($element_assigns as $ea){
            array_push($elements, $ea->getElement());
        }
        return $elements;
    }

//    public function set_data_access(\App\classes\OutputClasses\dao\OutputDataAccess $outputdata)
//    {
//        $this->outputdata = $outputdata;
//    }
//
//    public function get($exam)
//    {
//        $results = $this->outputdata->get_element_averages($exam);
//    }
//
//    /**
//     *
//     * @param \UserManagement\DisposableIDLookup $did
//     * @param type                               $access_token
//     * @param \UtilityClasses\Settings           $set
//     */
//    public function __construct(\UserManagement\DisposableIDLookup $did, $access_token, \UtilityClasses\Settings $set)
//    {
//        parent::__construct($did, $access_token);
//        if ($this->check_fully_loaded()) {
//
//            $this->query = "SELECT AVG(elementScore) AS elementAverage, elementID, elementAbbr, questionNumber
//			FROM elementScores
//			NATURAL JOIN elements
//			NATURAL JOIN questionAssigner
//			NATURAL JOIN elementsXquestions
//			WHERE examID = :examID
//			GROUP BY questionNumber, elementAbbr";
////            "SELECT AVG(elementScore) AS elementAverage, elementID, elementAbbr, questionNumber
////			FROM elementScores es
////			INNER JOIN elements e USING(elementID)
////			INNER JOIN questionAssigner qa USING(questionID)
////			INNER JOIN elementsXquestions exq USING(elementID)
////			WHERE examID = :examID
////			GROUP BY questionNumber, elementAbbr""
//            $this->vals = array('examID' => $this->examID);
//            if ($set->toSend() == true) {
//                $this->sendDataJson();
//            }
//        }
//    }



}
