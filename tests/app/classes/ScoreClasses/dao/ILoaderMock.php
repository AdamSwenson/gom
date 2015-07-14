<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/6/15
 * Time: 2:06 PM
 */

namespace App\classes\ScoreClasses\dao;


class ILoaderMock extends \classes\MockParent implements ILoader
{

    /**
     * @param \Student $student
     */
    public function setStudent(\Student $student)
    {
        $this->record_call(__FUNCTION__, array($student));
    }

    /**
     * @param \Exam $exam
     */
    public function setExam(\Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($exam));
    }

    /**
     * Gets all scores for the exam.
     * @return mixed
     */
    public function all()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }

    /**
     * Gets either all scores in the exam for a particular question/ element
     * or a particular student's scores if self::$student is set.
     *
     * If self::$exam is
     * not set, then gets all question or element scores for that question/element
     * across exams
     *
     * @param $object Either a \Question or \Element with its id set
     * @return mixed
     */
    public function object($object)
    {
        $this->record_call(__FUNCTION__, array($object));
        return $this->response;
    }

    /**
     * Gets either all question/ element scores in the exam for a question number
     * or a particular student's scores if self::$student is set
     * @param $questionNumber Int
     * @return mixed
     */
    public function question_number($questionNumber)
    {
        $this->record_call(__FUNCTION__, array($questionNumber));
        return $this->response;
    }
}