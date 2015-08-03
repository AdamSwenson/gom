<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 5:26 PM
 */
namespace App\Repositories\Question;

use App\QuestionAssignment;


/**
 * Class QuestionAssignmentRepository
 *
 * Replaces questionAssignmentDao
 *
 * @package Repositories\Question
 */
interface IQuestionAssignmentRepository
{
    /**
     * Loads and returns a question assignment
     * TODO: Add eager loading of question
     *
     * @param $examId
     * @param $question_number
     * @return QuestionAssignment
     */
    public function load($examId, $question_number);

    /** Returns question number from question ID
     * @param $examId
     * @param $questionId
     * @return mixed
     */
    public function loadByIds($examId, $questionId);

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
     * Gets questions for exam, ordered by question number
     * Returns a collection of QuestionAssignment objects.
     * TODO: Add eager loading of question
     *
     * @param $examId
     * @return
     *
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