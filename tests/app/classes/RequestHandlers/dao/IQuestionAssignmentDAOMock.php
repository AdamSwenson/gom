<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/21/15
 * Time: 4:35 PM
 */

namespace App\classes\RequestHandlers\dao;


use App\classes\MockParent;
use App\Exam;
use App\Question;

class IQuestionAssignmentDAOMock extends MockParent implements IQuestionAssignmentDAO
{

    public function load($examId, $question_number)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId, $question_number));
        return $this->response;
    }

    public function load_all_for_exam($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));
        return $this->response;
  }

    function record($examId, $questionId, $question_number)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId, $questionId, $question_number));
        return $this->response;
    }


    function remove($examId, $questionId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId, $questionId));
        return $this->response;
    }
}