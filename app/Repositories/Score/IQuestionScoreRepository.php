<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 9:27 PM
 */
namespace App\Repositories\Score;

use App\QuestionScore;

interface IQuestionScoreRepository
{
    /**
     * Loads all question scores for a student on an exam
     * @param $examId
     * @param $studentId
     */
    public function load_for_student_on_exam($examId, $studentId);

    /**
     * Loads all scores for a given question on an exam
     * @param $examId
     * @param $questionNumber
     */
    public function load_all_for_question_number($examId, $questionNumber);

    /**
     * @param $questionAssignmentId
     * @param $studentId
     * @return QuestionScore
     */
    public function load($questionAssignmentId, $studentId);

    /**
     * Saves the question score
     * @param $questionAssignmentId
     * @param $studentId
     * @param $score
     * @return boolean
     */
    public function update($questionAssignmentId, $studentId, $score);
}