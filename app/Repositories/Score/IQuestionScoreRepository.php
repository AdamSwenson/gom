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
     * @return Array of objects - NOT GRADE OBJECTS
     */
    public function load_for_student_on_exam($examId, $studentId);

    /**
     * Returns the total of all question scores for the student on the exam.
     * Will return 0 if there are no scores recorded for the student.
     * @param $examId
     * @param $studentId
     * @return int|float
     */
    public function load_total_for_student_on_exam($examId, $studentId);

    /**
     * Returns an array with either questionNumber, questionId, or
     * questionAssignmentId as the keys (with just the scores for that
     * question as the values of each key).
     * Defaults to returning with questionNumber as key
     * @param $examId
     * @param null $keyType What to use as keys (use constants)
     * @return array
     */
    public function load_all_for_exam($examId, $keyType = null);

    /**
     * Loads all scores for a given question on an exam.
     * This returns an array of stdClass objects, each of which has a score property.
     * So to access the score of the first item you would do $result[0]->score
     *
     * @param $examId
     * @param $questionNumber
     * @return array of StdClass objects
     */
    public function load_all_for_question_number($examId, $questionNumber);

    /**
     * Loads all scores for a given question on an exam.
     * This returns an array of stdClass objects, each of which has a score property.
     * So to access the score of the first item you would do $result[0]->score
     * @param integer $examId
     * @param integer $questionId
     * @return array of StdClass objects
     */
    public function load_all_for_question_id($examId, $questionId);

    /**
     * @param $questionAssignmentId
     * @param $studentId
     * @return QuestionScore
     */
    public function load($questionAssignmentId, $studentId);


    /**
     * Saves or updates the question score
     *
     * This and update do the same thing. Just added the extra method for clarity
     * and compatibility.
     *
     * @param $questionAssignmentId
     * @param $studentId
     * @param $score
     * @return QuestionScore
     */
    public function record($questionAssignmentId, $studentId, $score);

    /**
     * Saves or updates the question score
     *
     * This and record do the same thing. Just added the extra method for clarity
     * and compatibility.
     *
     * @param $questionAssignmentId
     * @param $studentId
     * @param $score
     * @return QuestionScore
     */
    public function update($questionAssignmentId, $studentId, $score);

    /**
     * Deletes a question score for a student
     * @param integer $questionAssignmentId
     * @param integer $studentId
     * @return boolean
     */
    public function deleteScore($questionAssignmentId, $studentId);
}