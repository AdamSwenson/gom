<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/23/15
 * Time: 9:33 AM
 */
namespace App\Repositories\Grade;

use App\Exam;
use App\Grade;
use App\GradeAssignment;


/**
 * This handles the assignment of grades based on total exam score
 *
 * @package App\Repositories\Grade
 */
interface IGradeAssignmentRepository
{
    /**
     * Retrieves grade assignments for the exam
     * @param Exam $exam
     * @return collection of GradeAssignment objects
     */
    public function load_grade_assignments_for_exam(Exam $exam);

    /**
     * Record a grade assignment to the database
     *
     * @param Exam $exam
     * @param Grade $grade
     * @param $minimumScore
     * @return GradeAssignment
     */
    public function record_grade_assignment(Exam $exam, Grade $grade, $minimumScore);

    /**
     * Removes a grade assignment
     *
     * @param Exam $exam
     * @param Grade $grade
     * @return bool|null
     * @throws \Exception
     */
    public function delete_grade_assignment(Exam $exam, Grade $grade);
}