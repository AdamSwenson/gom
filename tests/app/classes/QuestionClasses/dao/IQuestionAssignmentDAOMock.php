<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 2:36 PM
 */

namespace App\classes\QuestionClasses\dao;


use App\classes\MockParent;

class IQuestionAssignmentDAOMock extends MockParent implements IQuestionAssignmentDAO
{

    /**
     * Loads and returns a question assignment
     * @param \Exam $exam
     * @param $question_number
     * @return \QuestionAssigner
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, $question_number)
    {
        $this->called = __FUNCTION__;
        array_push($this->arguments, $exam);
        array_push($this->arguments, $question_number);
        return $this->response;
    }

    /**
     * @param \Exam $exam
     * @param \Question $question
     * @param $question_number
     * @throws \Propel\Runtime\Exception\PropelException
     * @return Boolean
     */
    function record(\Exam $exam, \Question $question, $question_number)
    {
        $this->called = __FUNCTION__;
        array_push($this->arguments, $exam);
        array_push($this->arguments, $question);
        array_push($this->arguments, $question_number);
        return $this->response;
    }

    /**
     * @param \Exam $exam
     * @return \Propel\Runtime\Collection\ObjectCollection|\QuestionAssigner[]
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_for_exam(\Exam $exam)
    {
        $this->called = __FUNCTION__;
        array_push($this->arguments, $exam);
        return $this->response;

    }
}