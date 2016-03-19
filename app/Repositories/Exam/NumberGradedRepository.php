<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/9/15
 * Time: 12:36 PM
 */

namespace App\Repositories\Exam;

use App\Exam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

/**
 * This handles operations for determining how many students have been graded on a given exam
 * @package Repositories\Exam
 */
class NumberGradedRepository implements INumberGradedRepository
{
    const KEY_BASE = 'graded_for_exam_';

    /**
     * Queries the main database to calculate how many have
     * been graded
     * @param Exam $exam
     * @return int ;
     */
    public function calculateNumberGradedFromMySQL(Exam $exam)
    {
        $query = <<<MYSQL
        SELECT count( DISTINCT student_id) AS numberGraded
        FROM question_scores qs
        INNER JOIN question_assignments qa ON qs.question_assignment_id = qa.id
        WHERE qa.exam_id = :examId;
MYSQL;
        //get counts
        $result = DB::select($query, ['examId' => $exam->id]);
        $numberGraded = $result[0]->numberGraded;

        return !empty($numberGraded) ? $numberGraded : 0 ;
    }

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
     * @return bool
     */
    public function updateNumberGradedByOne(Exam $exam)
    {
        $key = $this->buildKey($exam);
        Redis::incr($key);

        return true;
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
     * @return bool
     */
    public function deleteExamRecords(Exam $exam)
    {
        $key = $this->buildKey($exam);
        Redis::del($key);
        return true;
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