<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 1:21 PM
 */

namespace App\classes\RequestHandlers\dao;


use App\classes\MockParent;
use App\classes\SecurityClasses\cleaning\ICleanerFactory;
use App\Exam;
use Propel\Runtime\Connection\ConnectionWrapper;

class IExamDAOMock extends MockParent implements IExamDAO
{
    public $response;
    public $called;
    public $arguments = array();

    public $year;
    public $term;
    public $topic;

    function __construct()
    {
        $this->response = TRUE;
    }

    /**
     * Creates a new exam object, saves it, then returns it
     * @param \Year $year
     * @param \Term $term
     * @param \Topic $topic
     * @return \Exam
     */
    function save_new_exam($year, $term, $topic)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($year, $term, $topic));

        $this->year = $year;
        $this->term = $term;
        $this->topic = $topic;
        return $this->response;
    }

    /**
     * Returns all exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_all_exams()
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array());
     return $this->response;
    }

    public function load_exams_by_class($classId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($classId));
        return $this->response;
    }

    /**
     * Returns all unlocked exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_unlocked_exams()
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array());
        return $this->response;
    }


    /**
     * Deletes the exam
     * @param Exam $examId
     * @return mixed|void
     * @internal param Exam $exam
     */
    public function delete_exam($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));
        return $this->response;
    }

    /**
     * Marks the exam locked
     * @param $examId
     * @return bool
     */
    public function lock_exam($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));
        return $this->response;
    }

    /**
     * Marks the exam unlocked
     * @param $examId
     * @return bool
     * @internal param Exam $exam
     */
    public function unlock_exam($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));
        return $this->response;
    }

    /**
     * Marks the exam released
     * @param $examId
     * @return bool
     * @internal param Exam $exam
     */
    public function mark_exam_released($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));
        return $this->response;
    }

    /**
     * Marks the exam as unreleased
     * @param $examId
     * @return bool
     */
    public function unmark_exam_released($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));
        return $this->response;
    }

    /**
     * Load exam by id
     *
     * @param $examId
     * @return mixed
     */
    public function load_exam($examId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examId));
        return $this->response;
    }
}