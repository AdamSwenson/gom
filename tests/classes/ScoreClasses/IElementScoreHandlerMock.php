<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/20/15
 * Time: 4:05 PM
 */

namespace ScoreClasses;


class IElementScoreHandlerMock extends \classes\MockParent implements IElementScoreHandler
{

    /**
     * @param \Exam $exam
     * @param \Element $element
     * @param \Student $student
     * @return mixed|\QuestionScore
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, \Element $element, \Student $student)
    {
        $this->record_call(__FUNCTION__, array($exam, $element, $student));
        return $this->response;
    }

    /**
     * Saves the question score
     * @param \Exam $exam
     * @param \Element $element
     * @param \Student $student
     * @param $score
     * @return bool|\classes\The
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(\Exam $exam, \Element $element, \Student $student, $score)
    {
        $this->record_call(__FUNCTION__, array($exam, $element, $student, $score));
        return $this->response;
    }
}