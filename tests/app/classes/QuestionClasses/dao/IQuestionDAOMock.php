<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 2:34 PM
 */

namespace App\classes\QuestionClasses\dao;


class IQuestionDAOMock extends \classes\MockParent implements IQuestionDAO
{

    /**
     * Loads a question object from an array
     * @param array $incoming
     * @return \Question
     */
    public function get_question_from_array(array $incoming)
    {
        $this->called = __FUNCTION__;
//        $this->called = 'get_question_from_array';
        array_push($this->arguments, $incoming);
        return $this->response;
    }

    /**
     * Handles getting a new question object to deal with the various legal
     * incoming arrays.
     * @param int $questionID
     * @return Question
     */
    public function get_question($questionID)
    {
        $this->called = __FUNCTION__;
        array_push($this->arguments, $questionID);
        return $this->response;
    }

    /**
     * Fills a question with content from incoming
     * @param \Question $question
     * @param array $incoming
     * @return \Question
     */
    public function load_question_content(\Question $question, array $incoming)
    {
        $this->called = __FUNCTION__;
        array_push($this->arguments, $question);
        array_push($this->arguments, $incoming);
        return $this->response;
    }
}