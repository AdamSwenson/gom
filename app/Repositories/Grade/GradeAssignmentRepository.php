<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/22/15
 * Time: 2:09 PM
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
class GradeAssignmentRepository implements IGradeAssignmentRepository
{

    /**
     * Retrieves grade assignments for the exam
     * @param Exam $exam
     * @return collection of GradeAssignment objects
     */
    public function load_grade_assignments_for_exam(Exam $exam)
    {
        return GradeAssignment::where('exam_id', $exam)->all();
    }


    /**
     * Record a grade assignment to the database
     *
     * @param Exam $exam
     * @param Grade $grade
     * @param $minimumScore
     * @return GradeAssignment
     */
    public function record_grade_assignment(Exam $exam, Grade $grade, $minimumScore)
    {
        //Try retrieving a grade assignment for the exam/grade
        $assignment = $this->load_assignment($exam, $grade);

        //If there is no assignment yet, create an assignment object
        if( empty( $assignment ) )
        {
            $assignment = $this->create_new_assignment($exam, $grade);
        }

        //Set the cutoff
        $assignment->setMinScore($minimumScore);

        $assignment->save();

        return $assignment;
    }

    /**
     * Removes a grade assignment
     *
     * @param Exam $exam
     * @param Grade $grade
     * @return bool|null
     * @throws \Exception
     */
    public function delete_grade_assignment(Exam $exam, Grade $grade)
    {
        $assignment = $this->load_assignment($exam, $grade);
        if( ! empty($assignment) )
        {
            return $assignment->delete();
        }
        return true;
    }

    /**
     * Retrieves an existing assignment from the database
     *
     * @param Exam $exam
     * @param Grade $grade
     * @return GradeAssignment|null
     */
    protected function load_assignment(Exam $exam, Grade $grade)
    {
        return GradeAssignment::where('exam_id', $exam->getId())
            ->where('grade_id', $grade->getId())
            ->first();
    }

    /**
     * Creates a new gradeAssignment model object with the exam and grade
     * but does not save it to the database yet.
     *
     * @param Exam $exam
     * @param Grade $grade
     * @return GradeAssignment
     */
    protected function create_new_assignment(Exam $exam, Grade $grade)
    {
        $assignment = new GradeAssignment();
        $assignment->exam()->associate($exam);
        $assignment->setGrade($grade);
        return $assignment;
    }
}