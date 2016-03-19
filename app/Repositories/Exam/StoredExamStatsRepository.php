<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/16/16
 * Time: 4:03 PM
 */

namespace App\Repositories\Exam;

use App\Exam;
use Illuminate\Support\Facades\Redis;


/**
 * This keeps track of the number of questions and number of students
 * associated on each exam so don't have to recompute every time load table.
 * @package App\Repositories\Exam
 */
class StoredExamStatsRepository implements IStoredExamStatsRepository
{

    const STUDENTS_KEY_BASE = 'students_for_exam_';

    const QUESTIONS_KEY_BASE = 'questions_for_exam_';

    /**
     * Returns the number of students that have been associated with the exam
     * @param Exam $exam
     * @return integer
     */
    public function getNumberStudents(Exam $exam)
    {
        $key = $this->buildStudentsKey($exam);
        $this->checkAndInitializeKey($key);

        return Redis::get($key);
    }

    /**
     * Returns the number of questions assigned to the exam
     * @param Exam $exam
     * @return integer
     */
    public function getNumberQuestions(Exam $exam)
    {
        $key = $this->buildQuestionsKey($exam);
        $this->checkAndInitializeKey($key);

        return Redis::get($key);
    }

    /**
     * Updates the number of questions associated with the exam by one
     * @param Exam $exam
     * @return bool
     */
    public function updateNumberQuestionsByOne(Exam $exam)
    {
        $key = $this->buildQuestionsKey($exam);
        Redis::incr($key);
        return true;
    }

    /**
     * Updates the number of students associated by one
     * @param Exam $exam
     * @return bool
     */
    public function updateNumberStudentsByOne(Exam $exam)
    {
        $key = $this->buildStudentsKey($exam);
        Redis::incr($key);
        return true;
    }

    /**
     * Adds the specified number of questions to the count for the exam.
     * If $resetFirst is true, will reset the counter to 0 before adding.
     * @param Exam $exam
     * @param $numberOfQuestions
     * @param bool $resetFirst
     * @return bool
     */
    public function addQuestions(Exam $exam, $numberOfQuestions, $resetFirst = false)
    {
        $key = $this->buildQuestionsKey($exam);
        if ( $resetFirst )
        {
            Redis::set($key, 0);
        }
        Redis::incrby($key, $numberOfQuestions);

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
    public function addStudents(Exam $exam, $numberOfStudents, $resetFirst = false)
    {
        $key = $this->buildStudentsKey($exam);
        if ( $resetFirst )
        {
            Redis::set($key, 0);
        }
        Redis::incrby($key, $numberOfStudents);

        return true;
    }

    /**
     * Removes all question and student records for the exam from redis
     * @param Exam $exam
     * @return bool
     */
    public function deleteExamRecords(Exam $exam)
    {
        $questionKey = $this->buildQuestionsKey($exam);
        Redis::del($questionKey);

        $studentKey = $this->buildStudentsKey($exam);
        Redis::del($studentKey);

        return true;
    }

    /**
     * Builds the key string and returns it
     * @param Exam $exam
     * @return string
     */
    protected function buildQuestionsKey(Exam $exam)
    {
        return self::QUESTIONS_KEY_BASE . $exam->getId();
    }

    /**
     * Builds the key string for students and returns it
     * @param Exam $exam
     * @return string
     */
    protected function buildStudentsKey(Exam $exam)
    {
        return self::STUDENTS_KEY_BASE . $exam->getId();
    }

    /**
     * Check whether there are any values stored for the current exam.
     * If not, creates the key and sets the value to 0
     * @param $key string
     */
    protected function checkAndInitializeKey($key)
    {
        if ( ! Redis::exists($key) )
        {
            Redis::set($key, 0);
        }
    }
}