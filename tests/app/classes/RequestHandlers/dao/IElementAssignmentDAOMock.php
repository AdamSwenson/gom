<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/22/15
 * Time: 4:36 PM
 */

namespace App\classes\RequestHandlers\dao;


use App\classes\MockParent;

class IElementAssignmentDAOMock extends MockParent implements IElementAssignmentDAO
{

    public function load_elements($examId, $questionId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId, $questionId));
        return $this->response;
    }

    public function load_by_exam($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));
        return $this->response;
    }


    public function record($examId, $questionId, $elementId, $subtask)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId, $questionId, $elementId, $subtask));
        return $this->response;
    }
}