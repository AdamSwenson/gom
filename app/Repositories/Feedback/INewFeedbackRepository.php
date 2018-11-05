<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 11/4/18
 * Time: 4:04 PM
 */

namespace App\Repositories\Feedback;

use App\Exam;
use App\Student;

interface INewFeedbackRepository
{
    /**
     * Creates the data array that will be used to display feedback
     * @param Exam $exam
     * @param Student $student
     * @return array
     */
    public function buildDataOutput( Exam $exam, Student $student );

    public function buildFeedback( Exam $exam, Student $student );

}