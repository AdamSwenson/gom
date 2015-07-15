<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 8:59 AM
 */

namespace App\classes\ScoreClasses;


use App\classes\MockParent;

class IOutputScoreDAOMock extends MockParent implements IOutputScoreDAO
{
    public function __call($name, $arguments)
    {
        $this->called = __FUNCTION__;
        $this->record_call(__FUNCTION__, array($name, $arguments));
    }

    public function all_question_scores(\Exam $exam, \Student $student)
    {
        $this->called = __FUNCTION__;
        // TODO: Implement all_question_scores() method.
    }

    public function particular_question_score(\Exam $exam, \Student $student, \Question $question)
    {
        $this->called = __FUNCTION__;
        // TODO: Implement particular_question_score() method.
    }

    public function all_element_scores(\Exam $exam, \Student $student)
    {
        $this->called = __FUNCTION__;
        // TODO: Implement all_element_scores() method.
    }

    public function particular_element_score($exam, $student, $element)
    {
        $this->called = __FUNCTION__;
        // TODO: Implement particular_element_score() method.
    }

    public function get_comments(\Exam $exam, \Student $student)
    {
        $this->called = __FUNCTION__;
        // TODO: Implement get_comments() method.
    }
}