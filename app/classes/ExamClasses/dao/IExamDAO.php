<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 9:47 AM
 */

namespace App\classes\ExamClasses\dao;


use Propel\Runtime\Connection\ConnectionWrapper;

interface IExamDAO
{
    /**
     * Sets a connection object for use with transactions
     * @param ConnectionWrapper $conn
     * @return mixed
     */
    public function set_connection(ConnectionWrapper $conn);

    /**
     * Creates a new exam object, saves it, then returns it
     * @param \Year $year
     * @param \Term $term
     * @param \Topic $topic
     * @return \Exam
     */
    public function save_new_exam(\Year $year, \Term $term, \Topic $topic);

    /**
     * Returns all exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_all_exams();

    /**
     * Returns all unlocked exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_unlocked_exams();

    /**
     * Marks the exam locked
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function lock_exam(\Exam $exam);

    /**
     * Marks the exam unlocked
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function unlock_exam(\Exam $exam);

    /**
     * Marks the exam released
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function mark_exam_released(\Exam $exam);

    /**
     * Marks the exam as unreleased
     * @param \Exam $exam
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function unmark_exam_released(\Exam $exam);

}