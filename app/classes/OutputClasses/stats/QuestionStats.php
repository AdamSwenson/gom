<?php

namespace OutputClasses\stats;

/**
 * Gets average score on each question for all students taking the exam
 *
 * @todo Rewrite to call a stored procedure
 * @author adam
 */
class QuestionStats implements IStatsWorker
{
    public  $avg_key = 'questionAverage';

    public $id_key = 'questionID';

    /** @var  \ScoreClasses\dao\ScoreDAO */
    public $score_dao;

    /**
     * @param \ScoreClasses\dao\ScoreDAO $score_dao
     */
    public function setScoreDao($score_dao)
    {
        $this->score_dao = $score_dao;
    }



    public function get_scores(\Exam $exam, $item)
    {
        $scores = array();
        $this->score_dao->setExam($exam);
        $es = $this->score_dao->load('question', $item);
//        $es = \QuestionScoreQuery::create()
//            ->filterByExam($exam)
//            ->filterByQuestion($item)
//            ->find();
        foreach($es as $e){
            array_push($scores, $e->getQuestionscore());
        }
        return $scores;
    }

    public function get_items(\Exam $exam)
    {
        $questions = array();
        $question_assigns = \QuestionAssignerQuery::create()
            ->filterByExam($exam)
            ->orderByQuestionnumber()
            ->find();
        foreach($question_assigns as $qa){
            array_push($questions, $qa->getQuestion());
        }
        return $questions;
    }

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
//            $this->query = "SELECT AVG(qs.questionScore) AS questionAverage, qs.questionID, qa.questionNumber
//				FROM questionScores qs
//				INNER JOIN questionAssigner qa ON qs.questionID = qa.questionID
//				WHERE qs.examID = :examID
//				GROUP BY questionNumber
//                ORDER BY questionNumber ASC";
//            $this->vals = array('examID' => $this->examID);
//            if ($set->toSend() == true) {
//                $this->sendDataJson();
//            }
//            if ($set->toPrint() == true) {
//                $this->returnAssocAll;
//            }
//        }
//    }

#question averages
}
