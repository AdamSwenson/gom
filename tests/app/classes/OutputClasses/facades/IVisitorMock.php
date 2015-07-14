<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 8:41 AM
 */

namespace App\classes\OutputClasses\facades;


use App\classes\MockParent;

class IVisitorMock extends MockParent implements IVisitor
{

    public $examid;
    public $sid;
    public $name;

    public function set_examID($examid)
    {
        $this->examid = $examid;
    }

    public function set_studentID($sid)
    {
        $this->sid = $sid;
    }

    public function set_studentname($name)
    {
        $this->name = $name;
    }

    static public function make(\Exam $exam, \Student $student)
    {
        // TODO: Implement make() method.
    }

    public function examID()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->examid;
    }

    public function studentID()
    {
        return $this->sid;
    }

    public function studentName()
    {
        return $this->name;
    }
}