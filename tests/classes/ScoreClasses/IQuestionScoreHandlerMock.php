<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/20/15
 * Time: 4:08 PM
 */

namespace ScoreClasses;


class IQuestionScoreHandlerMock extends \classes\MockParent implements IQuestionScoreHandler
{

    /**
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @return mixed|\QuestionScore
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, \Question $question, \Student $student)
    {
        $this->record_call(__FUNCTION__, array($exam, $question, $student));
        return $this->response;
    }

    /**
     * Saves the question score
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @param $score
     * @return bool|\classes\The
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(\Exam $exam, \Question $question, \Student $student, $score)
    {
        $this->record_call(__FUNCTION__, array($exam, $question, $student));
        return $this->response;    }
}