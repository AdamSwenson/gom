<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 10:57 AM
 */

namespace App\Repositories\Score;


use App\ElementScore;
use App\Repositories\Question\IQuestionAssignmentRepository;

class ElementScoreRepository implements IElementScoreRepository
{
    /** @var  ElementScore */
    public $score_object;

    /**
     * @param integer $elementAssignmentId
     * @param integer $studentId
     * @return ElementScore
     */
    public function load($elementAssignmentId, $studentId)
    {
        $this->score_object = ElementScore::onStudentElementAssignment($studentId, $elementAssignmentId)->first();

        return $this->score_object;
    }

    /**
     * Loads all element scores for a given question on an exam
     * @param IQuestionAssignmentRepository $questionAssigner
     * @param $examId
     * @param $questionNumber
     */
    public function load_all_for_question_number(IQuestionAssignmentRepository $questionAssigner, $examId, $questionNumber)
    {
        $assignment = $questionAssigner->load($examId, $questionNumber);
        ElementScore::whereHas('questionAssignment', function($query, $assignment){
            $query->where('id', $assignment->getId());
        });
    }

    /**
     * Loads all question scores for a student on an exam
     * @param $examId
     * @param $studentId
     */
    public function load_for_student_on_exam($examId, $studentId)
    {
return ElementScore::where('student_id', $studentId)->where('exam_id', $examId)->first();
    }


    /**
     * Saves the question score
     * @param $elementAssignmentId
     * @param $studentId
     * @param $score
     * @return ElementScore
     **/
    public function update($elementAssignmentId, $studentId, $score)
    {
        $this->load($elementAssignmentId, $studentId);
        $this->score_object->setScore($score);

        return $this->score_object->update();
    }
}