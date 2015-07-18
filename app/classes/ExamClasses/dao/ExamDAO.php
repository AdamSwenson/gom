<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 1:14 PM
 */

namespace App\classes\ExamClasses\dao;


use App\classes\Traits\UserTraits;
use App\classes\UserManagement\errors\CredentialsException;
use Base\ExamQuery;
use Propel\Runtime\Connection\ConnectionWrapper;

class ExamDAO implements IExamDAO
{
    use UserTraits;

    /** @var  PropelPDO */
    public $connection = null;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }


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
     * @param  integer $year
     * @param string $term
     * @param string $topic
     * @return \Exam
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function save_new_exam($year, $term, $topic)
    {
        $exam = ExamQuery::create()
            ->filterByUser($this->user)
            ->filterByExamyear($year)
            ->filterByExamterm($term)
            ->filterByExamtopic($topic)
            ->findOneOrCreate();
        $exam->save($this->connection);
//        $exam = new \Exam();
//        $exam->setUser($this->user);
//        $exam->setTopic($topic);
//        $exam->setYear($year);
//        $exam->setTerm($term);
//        $exam->save();
        return $exam;
    }

    /**
     * Deletes the exam
     * @param \Exam $exam
     * @return mixed|void
     * @throws CredentialsException
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function delete_exam(\Exam $exam)
    {
        if($this->isLoggedIn())
        {
            return $exam->delete($this->connection);
        }else{
            throw new CredentialsException("delete exam");
        }
    }

    /**
     * Returns all exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_all_exams()
    {
        $exams = \ExamQuery::create()
            ->filterByUser($this->user)
            ->find($this->connection);
        return $exams;
    }

    /**
     * Returns all unlocked exams
     * @return \Exam[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function load_unlocked_exams()
    {
        $exams = \ExamQuery::create()
            ->filterByUser($this->user)
            ->filterByLocked(0)
            ->find();
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
        return $exam->save($this->connection);
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
        return $exam->save($this->connection);
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
        return $exam->save($this->connection);
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