<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 10:57 AM
 */

namespace App\Repositories\Score;


use App\QuestionScore;

class QuestionScoreRepository implements IQuestionScoreRepository
{
    protected $score_object;

    /**
     * Loads all question scores for a student on an exam
     * @param $examId
     * @param $studentId
     */
    public function load_for_student_on_exam($examId, $studentId)
    {

    }

    /**
     * Loads all scores for a given question on an exam
     * @param $examId
     * @param $questionNumber
     */
    public function load_all_for_question_number($examId, $questionNumber)
    {

    }



    /**
     * @param $questionAssignmentId
     * @param $studentId
     * @return QuestionScore
     */
    public function load($questionAssignmentId, $studentId)
    {
        $this->score_object = QuestionScore::where('student_id', $studentId)->where('question_assignment_id', $questionAssignmentId)->first();
        return $this->score_object;
    }

    /**
     * Saves the question score
     * @param $questionAssignmentId
     * @param $studentId
     * @param $score
     * @return boolean
     */
    public function update($questionAssignmentId, $studentId, $score)
    {
        $this->load($questionAssignmentId, $studentId);
        $this->score_object->setScore($score);
        return $this->score_object->update();
    }
}