<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/20/15
 * Time: 3:58 PM
 */

namespace ScoreClasses;


interface IQuestionScoreHandler
{

    /**
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @return mixed|\QuestionScore
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, \Question $question, \Student $student);

    /**
     * Saves the question score
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @param $score
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(\Exam $exam, \Question $question, \Student $student, $score);
}