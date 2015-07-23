<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 1:21 PM
 */

namespace App\classes\ExamClasses\dao;


use App\classes\MockParent;
use App\classes\SecurityClasses\cleaning\ICleanerFactory;
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

//    public function __call($name, $arguments)
//    {
//        $this->called = $name;
//        $this->arguments = $arguments;
//        $this->$name($arguments);
//    }
//
//    public function set_response($response)
//    {
//        $this->response = $response;
//    }

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
     return $this->response;
    }

    /**
     * Returns all unlocked exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_unlocked_exams()
    {
        return $this->response;
    }

    /**
     * Marks the exam locked
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function lock_exam(\Exam $exam)
    {
       // $this->called = __FUNCTION__;
        //$this->record_call(__FUNCTION__, array($exam));
        $this->called = 'lock_exam';
        return $this->response;
    }

    /**
     * Marks the exam unlocked
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function unlock_exam(\Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($exam));
        $this->called = __FUNCTION__;

        return $this->response;
    }

    /**
     * Marks the exam released
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function mark_exam_released(\Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($exam));
        return $this->response;
    }

    /**
     * Marks the exam as unreleased
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function unmark_exam_released(\Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($exam));
        return $this->response;
    }

    /**
     * Sets a connection object for use with transactions
     * @param ConnectionWrapper $conn
     * @return mixed|void
     */
    public function set_connection(ConnectionWrapper $conn){}

    /**
     * Deletes the exam after checking that the user is authenticated
     * @param \Exam $exam
     * @return mixed
     */
    public function delete_exam(\Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($exam));
        return $this->response;
    }

    /**
     * Loads the class which handles cleaning before query
     * @param ICleanerFactory $cleanerFactory
     */
    public function set_cleaner(ICleanerFactory $cleanerFactory)
    {
    }
}