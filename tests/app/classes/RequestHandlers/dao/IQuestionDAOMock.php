<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 2:34 PM
 */

namespace App\classes\RequestHandlers\dao;


use App\classes\MockParent;

class IQuestionDAOMock extends MockParent implements IQuestionDAO
{


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