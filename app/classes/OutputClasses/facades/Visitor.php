<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 7:18 AM
 */

namespace OutputClasses\facades;


class Visitor implements IVisitor
{

    protected $exam;

    protected $student;

    protected function set_exam(\Exam $exam)
    {
        $this->exam = $exam;
    }

    protected function set_student(\Student $student)
    {
        $this->student = $student;
    }

    static public function make(\Exam $exam, \Student $student)
    {
        $newObj = new self;
        $newObj->set_exam($exam);
        $newObj->set_student($student);
        return $newObj;
    }

    public function examID()
    {
        return $this->exam->getId();
    }

    public function studentID()
    {
        return $this->student->getId();
    }

    public function studentName()
    {
        return $this->student->getStudentname();
    }
}