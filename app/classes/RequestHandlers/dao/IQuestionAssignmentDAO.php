<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 10:59 AM
 */

namespace App\classes\RequestHandlers\dao;


use App\Exam;
use App\Question;

interface IQuestionAssignmentDAO
{
    /**
     * Assigns a question to an exam as the specified question number
     * TODO: Add eager loading of question
     * @param Exam $examId
     * @param Question $questionId
     * @param $question_number
     * @return QuestionAssignment
     */
    public function record($examId, $questionId, $question_number);

    /**
     * Loads and returns a question assignment
     * @param $examId
     * @param $question_number
     * @return \App\QuestionAssignment
     */
    public function load($examId, $question_number);

    /**
     * @param $examId
     */
    public function load_all_for_exam($examId);


    /**
     * Removes the assignment of a question to an exam
     * @param $examId
     * @param $questionId
     * @return mixed
     */
    function remove($examId, $questionId);

}