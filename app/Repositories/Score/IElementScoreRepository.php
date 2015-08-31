<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 9:26 PM
 */
namespace App\Repositories\Score;

use App\ElementScore;
use App\Repositories\Question\IQuestionAssignmentRepository;

interface IElementScoreRepository
{
    /**
     * @param integer $elementAssignmentId
     * @param integer $studentId
     * @return ElementScore
     */
    public function load($elementAssignmentId, $studentId);

//    /**
//     * Loads all element scores for a given question on an exam
//     * @param $examId
//     * @param $questionNumber
//     */
//    public function load_all_for_question_number(
//        IQuestionAssignmentRepository $questionAssigner,
//        $examId,
//        $questionNumber
//    );

    /**
     * Loads all question scores for a student on an exam
     * @param $examId
     * @param $studentId
     */
    public function load_for_student_on_exam($examId, $studentId);

    /**
     * Saves or updates the element score
     *
     * This and update do the same thing. Just added the extra method for clarity
     * and compatibility.
     *
     * @param $elementAssignmentId
     * @param $studentId
     * @param $score
     * @return ElementScore
     */
    public function record($elementAssignmentId, $studentId, $score);

    /**
     * Saves or updates the element score
     *
     * This and record do the same thing. Just added the extra method for clarity
     * and compatibility.
     *
     * @param $elementAssignmentId
     * @param $studentId
     * @param $score
     * @return ElementScore
     **/
    public function update($elementAssignmentId, $studentId, $score);


    /**
     * Deletes the score and comment for a student
     * @param integer $elementAssignmentId
     * @param integer $studentId
     * @return bool
     */
    public function deleteScore($elementAssignmentId, $studentId);
}