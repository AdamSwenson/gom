<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 11:10 AM
 */

namespace App\classes\CommentClasses\dao;


class IAssignmentFactoryMock extends \classes\MockParent implements IAssignmentFactory
{


    public function set_exam(\Exam $exam)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($exam));
        return $this->response;
    }

    public function set_element(\Element $element)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($element));
        return $this->response;
    }


    public function load($type)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($type));
        return $this->response;
    }
}