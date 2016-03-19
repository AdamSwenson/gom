<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/16/16
 * Time: 4:45 PM
 */
namespace App\Repositories\Exam;

use App\Exam;


/**
 * This keeps track of the number of questions and number of students
 * associated on each exam so don't have to recompute every time load table.
 * @package App\Repositories\Exam
 */
interface IStoredExamStatsRepository
{
    /**
     * Returns the number of students that have been associated with the exam
     * @param Exam $exam
     * @return integer
     */
    public function getNumberStudents(Exam $exam);

    /**
     * Returns the number of questions assigned to the exam
     * @param Exam $exam
     * @return integer
     */
    public function getNumberQuestions(Exam $exam);

    /**
     * Updates the number of questions associated with the exam by one
     * @param Exam $exam
     */
    public function updateNumberQuestionsByOne(Exam $exam);

    /**
     * Updates the number of students associated by one
     * @param Exam $exam
     */
    public function updateNumberStudentsByOne(Exam $exam);

    /**
     * Adds the specified number of questions to the count for the exam.
     * If $resetFirst is true, will reset the counter to 0 before adding.
     * @param Exam $exam
     * @param $numberOfQuestions
     * @param bool $resetFirst
     * @return bool
     */
    public function addQuestions(Exam $exam, $numberOfQuestions, $resetFirst = false);

    /**
     * Adds the specified number of students to the count for the exam.
     * If $resetFirst is true, will reset the counter to 0 before adding.
     * @param Exam $exam
     * @param $numberOfStudents
     * @param bool $resetFirst
     * @return bool
     */
    public function addStudents(Exam $exam, $numberOfStudents, $resetFirst = false);

    /**
     * Removes all question and student records for the exam from redis
     * @param Exam $exam
     */
    public function deleteExamRecords(Exam $exam);
}