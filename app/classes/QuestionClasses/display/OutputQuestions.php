<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/10/15
 * Time: 8:21 AM
 */

namespace QuestionClasses\display;


class OutputQuestions
{
    public $encoder;

    public function set_encoder($encoder)
    {
        $this->encoder = $encoder;
    }

    protected function encode_and_send($output)
    {
        $encoded = json_encode($output, \JSON_FORCE_OBJECT);
//TODO Setup json encoder to handle this
//        $encoded = $this->encoder->encode($output);
        if(!$encoded){
            $encoded = json_encode(array(), \JSON_FORCE_OBJECT);
        }
        echo $encoded;
    }

    /**
     * Outputs a json object of all current questions or an empty json
     */
    public function display_all()
    {
        $questions = \QuestionQuery::create()->find();
        $output = array();
        foreach($questions as $q){
            array_push($output, array('questionID' => $q->getId(), 'questionName' => $q->getQuestionname(), 'questionText' => $q->getQuestiontext()));
        }
        $this->encode_and_send($output);
    }

    public function display_for_exam(\Exam $exam)
    {
        $question_assigments = \QuestionAssignerQuery::create()->filterByExam($exam)->find();
        $output = array();
        foreach($question_assigments as $qa)
        {
            $q = $qa->getQuestion();
            array_push($output, array('questionNumber' => $qa->getQuestionnumber(), 'questionID' => $q->getId(), 'questionName' => $q->getQuestionname(), 'questionText' => $q->getQuestiontext()));
        }
        $this->encode_and_send($output);
    }
}