<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/6/15
 * Time: 10:40 AM
 */

namespace App\classes\ScoreClasses\dao;


interface IScoreDAO 
{


    /**
     * @param \Student $student
     */
    public function setStudent(\Student $student);


    /**
     * @param \Exam $exam
     */
    public function setExam(\Exam $exam);


    /**
     * Loads score(s)
     * @param $kind \Question | \Element | integer | string(all | questionnumber)
     * @param $by
     * @param bool $arg
     * @return array
     * @throws \Exception
     */
    public function load($kind, $by, $arg=false);

    /**
     * Returns an array of element scores for the specified question number
     * @param \Exam $exam
     * @param \Student $student
     * @param $question_number
     * @return array
     */
    public function element_scores_by_question_number(\Exam $exam, \Student $student, $question_number);
}