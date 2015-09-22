<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/22/15
 * Time: 2:09 PM
 */

namespace Repositories\Grade;

use App\Exam;
use App\Grade;

/**
 * This handles the assignment of grades based on total exam score
 *
 * @package Repositories\Grade
 */
class GradeAssignmentRepository
{

    public function load_grade_assignments_for_exam(Exam $exam)
    {

    }

    
    public function record_grade_assignment(Exam $exam, Grade $grade, $minimumScore)
    {

    }
}