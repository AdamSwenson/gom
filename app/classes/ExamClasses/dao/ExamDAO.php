<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 1:14 PM
 */

namespace ExamClasses\dao;


use Propel\Runtime\Connection\ConnectionWrapper;

class ExamDAO implements IExamDAO
{

    /** @var  PropelPDO */
    public $connection;

    /**
     * Sets a connection object for use with transactions
     * @param ConnectionWrapper $conn
     * @return mixed|void
     */
    public function set_connection(ConnectionWrapper $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Creates a new exam object, saves it, then returns it
     * @param \Year $year
     * @param \Term $term
     * @param \Topic $topic
     * @return \Exam
     */
    public function save_new_exam(\Year $year, \Term $term, \Topic $topic)
    {
        $exam = new \Exam();
        $exam->setTopic($topic);
        $exam->setYear($year);
        $exam->setTerm($term);
        $exam->save();
        return $exam;
    }

    /**
     * Returns all exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_all_exams()
    {
        $exams = \ExamQuery::create()->find();
        return $exams;
    }

    /**
     * Returns all unlocked exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_unlocked_exams()
    {
        $exams = \ExamQuery::create()->filterByLocked(0)->find();
        return $exams;
    }

    /**
     * Marks the exam locked
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function lock_exam(\Exam $exam)
    {
        $exam->setLocked(1);
        return $exam->save();
    }

    /**
     * Marks the exam unlocked
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function unlock_exam(\Exam $exam)
    {
        $exam->setLocked(0);
        return $exam->save();
    }

    /**
     * Marks the exam released
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function mark_exam_released(\Exam $exam)
    {
        $exam->setReleased(1);
        return $exam->save();
    }

    /**
     * Marks the exam as unreleased
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function unmark_exam_released(\Exam $exam)
    {
        $exam->setReleased(0);
        if(isset($this->connection))
        {
            return $exam->save($this->connection);
        }else{
            return $exam->save();
        }
    }

}