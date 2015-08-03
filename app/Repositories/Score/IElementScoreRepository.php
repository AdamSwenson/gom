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
     * Saves the question score
     * @param $elementAssignmentId
     * @param $studentId
     * @param $score
     * @return ElementScore
     **/
    public function update($elementAssignmentId, $studentId, $score);
}