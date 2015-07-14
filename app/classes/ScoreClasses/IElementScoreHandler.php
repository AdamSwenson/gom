<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/20/15
 * Time: 3:57 PM
 */

namespace App\classes\ScoreClasses;


interface IElementScoreHandler
{

    /**
     * @param \Exam $exam
     * @param \Element $element
     * @param \Student $student
     * @return mixed|\QuestionScore
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, \Element $element, \Student $student);


    /**
     * Saves the question score
     * @param \Exam $exam
     * @param \Element $element
     * @param \Student $student
     * @param $score
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(\Exam $exam, \Element $element, \Student $student, $score);

}