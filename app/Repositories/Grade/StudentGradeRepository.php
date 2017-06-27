<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/9/15
 * Time: 3:59 PM
 */

namespace App\Repositories\Grade;

use App\Exam;
use App\Repositories\Grade\GradeFactory;
use App\Student;
use App\Repositories\Score\IQuestionScoreRepository;

/**
 * This handles retrieving and storing the grades given to each individual
 * student on the basis of the values stored in grade assignments
 *
 * @package Repositories\Grade
 */
class StudentGradeRepository
{

    /** @var \App\Repositories\Score\IQuestionScoreRepository */
    protected $questionScoreDao;

    /** @var \App\Repositories\Grade\IGradeAssignmentRepository  */
    protected $assignmentDao;

    /** @var  \App\Exam */
    protected $exam;

    public $gradeAssignments;

    /**
     * StudentGradeRepository constructor.
     */
    public function __construct()
    {
        $this->assignmentDao = app()->make(IGradeAssignmentRepository::class);
        $this->questionScoreDao = app()->make(IQuestionScoreRepository::class);
    }

    /**
     * Returns a grade object for the student on the exam.
     * This should be the main publicly called method.
     *
     * @param Exam $exam
     * @param Student $student
     * @return \App\Grade
     */
    public function getStudentGrade(Exam $exam, Student $student)
    {
        //Make sure everything is loaded and ready
        $this->loadGradeAssignments($exam);

        $totalScore = $this->calculateTotalScoreForStudent($exam, $student);

        return $this->determineGrade($totalScore);
    }


    /**
     * Calculate the total score for a student on the exam
     * @param Exam $exam
     * @param Student $student
     * @return float
     */
    public function calculateTotalScoreForStudent(Exam $exam, Student $student)
    {
        $questionScores = $this->questionScoreDao->load_for_student_on_exam($exam->getId(), $student->id);

        $examScore = 0;
        foreach ($questionScores as $score)
        {
            if (isset($score->questionScore))
            {
                $examScore += $score->questionScore;
            }
        }

        return $examScore;
    }


    /**
     * Determines the grade based on the grade assignments already loaded
     * @param $totalScore
     * @return \App\Grade|null
     */
    public function determineGrade($totalScore)
    {
        //Find the correct grade assignment
        $assignment = $this->searchForGrade($totalScore);

        if( !empty($assignment) )
        {
            //Load the corresponding grade
            return GradeFactory::loadByGradeId($assignment->grade_id);
        }
        return null;

    }


    /**
     * Iterates through the self::gradeAssignments collection. Finds and returns
     * the appropriate GradeAssignment.
     * @param $totalScore
     * @return GradeAssignment
     */
    protected function searchForGrade($totalScore)
    {

        for($i=0; $i<count($this->gradeAssignments); $i++)
        {
            //current grade object (to keep things neat)
            $g = $this->gradeAssignments[$i];

            if( $totalScore >= $g->getMinScore() )
            {
                return $g;
            }
        }
        return null;
    }

    /**
     * If the exam has not already been set or if it was set to a different exam,
     * we will set the exam property and load the grade assignments.
     * That way we don't have to do a query for every student.
     * @param Exam $exam
     */
    protected function loadGradeAssignments(Exam $exam)
    {
        if ( empty($this->exam) || $this->exam->getId() != $exam->getId() )
        {
            //Set the exam property
            $this->exam = $exam;
            //Load grade assignments
            $this->gradeAssignments = $this->assignmentDao->load_grade_assignments_for_exam($exam);
        }
    }
}