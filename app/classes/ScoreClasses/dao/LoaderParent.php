<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/6/15
 * Time: 2:38 PM
 */

namespace ScoreClasses\dao;


abstract class LoaderParent
{

    /** @var \Student */
    public $student;

    /** @var \Exam */
    public $exam;

    /**
     * @param \Student $student
     */
    public function setStudent(\Student $student)
    {
        $this->student = $student;
    }

    /**
     * @param \Exam $exam
     */
    public function setExam(\Exam $exam)
    {
        $this->exam = $exam;
    }
}