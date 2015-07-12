<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 10:48 AM
 */

namespace QuestionClasses\service;

/**
 * Class QuestionAssigner
 * This takes an incoming array and sets up the questions
 * @package classes\QuestionClasses\service
 */
class QuestionAssigner
{

    /** @var $question_assigner_dao \classes\QuestionClasses\dao\IQuestionAssignmentDAO */
    public $question_assigner_dao;

    /** @var  $question_dao \classes\QuestionClasses\dao\IQuestionDAO */
    public $question_dao;

    /** @var  $response_handler \JsonOutputClasses\controllers\IResponseChooser */
    public $response_handler;

    public $questions = array();

    public function set_response_handler(\JsonOutputClasses\controllers\IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }

    public function set_question_assigner_dao(\QuestionClasses\dao\IQuestionAssignmentDAO $question_assigner_dao)
    {
        $this->question_assigner_dao = $question_assigner_dao;
    }

    public function set_question_dao(\QuestionClasses\dao\IQuestionDAO $question_dao)
    {
        $this->question_dao = $question_dao;
    }

//    public function load_questions(array $incoming)
//    {
//        foreach($incoming as $q_row){
//            $question = $this->question_dao->get_question_from_array($q_row);
//            if($question){
//                array_push($this->questions, $question);
//            }
//        }
//    }

    /**
     * @param array $incoming
     * @return \Question
     */
    protected function load_question(array $incoming)
    {
        if (isset($incoming['questionID']) && ($incoming['questionID'] > 0))
        {
            $qid = (int) $incoming['questionID'];
            return \QuestionQuery::create()->filterById($qid)->findOne();
        }
        else {
            return new \Question();
        }
    }


    /**
     * @param \Exam $exam
     * @param array $incoming Should be an array of question arrays. Each sub array should have key 'questionNumber'
     */
    public function record_one(\Exam $exam, array $incoming)
    {
        if(isset($incoming['questionText']) && count($incoming['questionText']) > 0) {
            $question = $this->load_question($incoming);
            $question->setQuestiontext($incoming['questionText']);
            if (isset($incoming['questionName']))
            {
                $question->setQuestionname($incoming['questionName']);
            }
            if (isset($incoming['questionNumber'])) {
                $result = $this->question_assigner_dao->record($exam, $question, $incoming['questionNumber']);
                if ($result) {
                    $this->response_handler->handle_row_count(1);
                } else {
                    $this->response_handler->handle_row_count(0);
                }
            }
        }
        else
        {
            error_log('text not set');
            //TODO throw exception or log error?
            $this->response_handler->handle_row_count(0);
        }
    }


    /**
     * @param \Exam $exam
     * @param array $incoming Should be an array of question arrays. Each sub array should have key 'questionNumber'
     */
    public function record(\Exam $exam, array $incoming)
    {
        foreach ($incoming as $q_row) {
            if (array_key_exists('questionNumber', $q_row)) {
                $qnum = $q_row['questionNumber'];
                if (isset($qnum)) {
                    $question = $this->question_dao->get_question_from_array($q_row);
                    $this->question_assigner_dao->record($exam, $question, $qnum);
                }
            }
        }
    }

}