<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/9/15
 * Time: 12:36 PM
 */

namespace App\Repositories\Exam;

use App\Exam;
use Illuminate\Support\Facades\Redis;

/**
 * This handles operations for determining how many students have been graded on a given exam
 * @package Repositories\Exam
 */
class NumberGradedRepository implements INumberGradedRepository
{
    const KEY_BASE = 'graded_for_exam_';

    /**
     * Returns the number of students that have been graded for the exam
     * @param Exam $exam
     * @return integer
     */
    public function getNumberGraded(Exam $exam)
    {
        $key = $this->buildKey($exam);
        $this->checkAndInitializeKey($key);
        return Redis::get($key);
    }

    /**
     * Updates the number of students that have been graded by one
     * @param Exam $exam
     */
    public function updateNumberGradedByOne(Exam $exam)
    {
        $key = $this->buildKey($exam);
        Redis::incr($key);
    }

    /**
     * Adds the specified number of students to the count for the exam.
     * If $resetFirst is true, will reset the counter to 0 before adding.
     * @param Exam $exam
     * @param $numberOfStudents
     * @param bool $resetFirst
     * @return bool
     */
    public function addGradedStudents(Exam $exam, $numberOfStudents, $resetFirst = false)
    {
        $key = $this->buildKey($exam);
        if ( $resetFirst )
        {
            Redis::set($key, 0);
        }
        Redis::incrby($key, $numberOfStudents);

        return true;
    }


    /**
     * Removes all count records for the exam from redis
     * @param Exam $exam
     */
    public function deleteExamRecords(Exam $exam)
    {
        $key = $this->buildKey($exam);
        Redis::del($key);
    }

    /**
     * Builds the key string and returns it
     * @param Exam $exam
     * @return string
     */
    protected function buildKey(Exam $exam)
    {
        return self::KEY_BASE . $exam->getId();
    }

    /**
     * Check whether there are any values stored for the current exam.
     * If not, creates the key and sets the value to 0
     * @param $key string
     */
    protected function checkAndInitializeKey($key)
    {
        if( ! Redis::exists($key) )
        {
            Redis::set($key, 0);
        }
    }

}