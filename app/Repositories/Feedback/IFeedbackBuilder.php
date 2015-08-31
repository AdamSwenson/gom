<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 3:40 PM
 */
namespace App\Repositories\Feedback;

use App\Student;

interface IFeedbackBuilder
{
    /**
     * Creates the feedback structure
     * This is the main publicly called method
     * @param integer $examId
     */
    public function buildFeedback($examId);


    /**
     * Run the compilation process for a single student and replace the existing
     * feedback in the db with the results (and keep the same access key)
     *
     * This is the other main publicly called method
     *
     * @param integer $examId
     * @param Student $student
     * @return array
     */
    public function recompileFeedbackForStudent($examId, Student $student);
}