<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/6/15
 * Time: 10:45 AM
 */

namespace ScoreClasses\dao;


use classes\MockParent;

class IScoreDAOMock extends MockParent implements IScoreDAO
{


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


    /**
     * Returns an array of element scores for the specified question number
     * @param \Exam $exam
     * @param \Student $student
     * @param $question_number
     * @return array
     */
    public function element_scores_by_question_number(\Exam $exam, \Student $student, $question_number)
    {
        //$this->record_call(__FUNCTION__, array($exam, $student, $question_number));
        $es = \ElementScoreQuery::create()->find();
        $out = array();
        foreach($es as $e){
            array_push($out, $e);
        }
        return $out;
    }

    /**
     * Loads score(s)
     * @param $kind \Question | \Element | integer | string(all | questionnumber)
     * @param $by
     * @param bool $arg
     * @return array
     * @throws \Exception
     */
    public function load($kind, $by, $arg = false)
    {
     $this->record_call(__FUNCTION__, array($kind, $by, $arg));
        return $this->response;
    }
}