<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 2:34 PM
 */

namespace App\classes\QuestionClasses\dao;


use App\classes\MockParent;

class IQuestionDAOMock extends MockParent implements IQuestionDAO
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

    /**
     * Creates a new question
     * @param string $questionName
     * @param string $questionText
     * @return Question
     */
    public function createQuestion($questionName, $questionText)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($questionName, $questionText));
        return $this->response;
    }

    /**
     * Delete a question from the database (and from any exams it is associated with).
     * Note: Also removes any existing question scores or element scores.
     * @param integer $questionId
     * @return int
     */
    public function deleteQuestion($questionId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($questionId));
        return $this->response;
    }

    /**
     * Handles getting a new question object. Throws exception if does not exist
     * @param int $questionId
     * @return Question
     */
    public function loadQuestionById($questionId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($questionId));
        return $this->response;
    }

    /**
     * Load all questions for the user
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function loadAll()
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array());
        return $this->response;
    }

    public function loadQuestionsByClassId($classId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($classId));
        return $this->response;
    }
}