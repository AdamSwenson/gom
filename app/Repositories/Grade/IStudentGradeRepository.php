<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/18
 * Time: 6:37 PM
 */

namespace App\Repositories\Grade;

use App\Exam;
use App\Student;


/**
 * This handles retrieving and storing the grades given to each individual
 * student on the basis of the values stored in grade assignments
 *
 * @package Repositories\Grade
 */
interface IStudentGradeRepository
{
    /**
     * Returns a grade object for the student on the exam.
     * This should be the main publicly called method.
     *
     * @param Exam $exam
     * @param Student $student
     * @return \App\Grade
     */
    public function getStudentGrade( Exam $exam, Student $student );

    /**
     * Calculate the total score for a student on the exam
     * @param Exam $exam
     * @param Student $student
     * @return float
     */
    public function calculateTotalScoreForStudent( Exam $exam, Student $student );

    /**
     * Determines the grade based on the grade assignments already loaded
     * @param $totalScore
     * @return \App\Grade|null
     */
    public function determineGrade( $totalScore );
}