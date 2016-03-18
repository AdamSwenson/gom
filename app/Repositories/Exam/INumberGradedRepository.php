<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/9/15
 * Time: 12:56 PM
 */
namespace App\Repositories\Exam;

use App\Exam;


/**
 * This handles operations for determining how many students have been
 * graded on a given exam
 * @package Repositories\Exam
 */
interface INumberGradedRepository
{
    /**
     * Returns the number of students that have been graded for the exam
     * @param Exam $exam
     * @return integer
     */
    public function getNumberGraded(Exam $exam);

    /**
     * Updates the number of students that have been graded by one
     * @param Exam $exam
     */
    public function updateNumberGradedByOne(Exam $exam);
    /**
     * Removes all count records for the exam from redis
     * @param Exam $exam
     */
    public function deleteExamRecords(Exam $exam);
}