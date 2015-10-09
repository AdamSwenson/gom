<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 10:57 AM
 */

namespace App\Repositories\Score;


use App\ElementAssignment;
use App\ElementScore;
use App\Repositories\Question\IQuestionAssignmentRepository;

class ElementScoreRepository implements IElementScoreRepository
{
    /** @var  ElementScore */
    public $score_object;


    /**
     * Load score for a student by the id of the element assignment
     * @param integer $elementAssignmentId
     * @param integer $studentId
     * @return ElementScore
     */
    public function load($elementAssignmentId, $studentId)
    {
        $this->score_object = ElementScore::firstOrNew(['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId]);
        return $this->score_object;

//        ElementScore::where('element_assignment_id', $elementAssignmentId)->where('student_id', $studentId)->
//        $this->score_object = ElementScore::onStudentElementAssignment($studentId, $elementAssignmentId)->first();
    }


    /**
     * Loads all of a students scores on elements associated with a question by the question's id number.
     * The results will be in ascending order via subtask.
     * Returns array with following keys:
     *      elementId: The id of the element
     *      elementName: The name of the element for display
     *      subtask: The order in which the element appears for the question
     *      elementAssignmentId: The id of the association between element and question
     *      questionNumber: The number of the question on the exam
     *      elementScore: Float value of the score or NULL if not yet graded.
     *
     * @param integer $examId
     * @param integer $questionId
     * @param integer $studentId
     * @return mixed
     */
    public function load_all_for_student_by_question_id($examId, $questionId, $studentId)
    {
        $query = <<<MYSQL
SELECT e.id AS elementId,
    e.elementName AS elementName,
    exq.subtask AS subtask,
    exq.id AS elementAssignmentId,
    (SELECT qa.question_number FROM question_assignments qa
        WHERE qa.exam_id = :examId
            AND qa.question_id = :questionId
    ) AS questionNumber,
    (SELECT score AS elementScore
        FROM element_scores
        WHERE element_assignment_id = elementAssignmentId
        AND student_id = :studentId
    ) AS elementScore
    FROM elements e
        INNER JOIN element_assignments exq ON e.id = exq.element_id
        WHERE
            e.user_id = :userId
            AND exq.exam_id = :examId2
            AND exq.question_id = :questionId2
        ORDER BY exq.subtask ASC;
MYSQL;
        $uid = \Auth::user()->id;
       // $query = "CALL get_element_scores_for_student_by_question_id(:userId, :examId, :questionId, :studentId, @elementId, @elementName, @questionNumber, @subtask, @elementAssignmentId, @elementScore)";
        $values = [
            'userId' => $uid,
            'examId' => $examId,
            'examId2' => $examId,
            'questionId' => $questionId,
            'questionId2' => $questionId,
            'studentId' => $studentId
        ];
        return \DB::select($query, $values);
        //TODO Error handling
    }


//    /**
//     * Loads all element scores for a given question on an exam
//     * @param IQuestionAssignmentRepository $questionAssigner
//     * @param $examId
//     * @param $questionNumber
//     */
//    public function load_all_for_question_number(IQuestionAssignmentRepository $questionAssigner, $examId, $questionNumber)
//    {
//        $assignment = $questionAssigner->load($examId, $questionNumber);
//        $elementAssignments = ElementScore::whereHas('questionAssignment', function ($query, $assignment)
//            {
//                $query->where('id', $assignment->getId());
//            });
//    }

    /**
     * Loads all element scores for a student on an exam
     * @param $examId
     * @param $studentId
     * @return Collection
     */
    public function load_for_student_on_exam($examId, $studentId)
    {
        $scores = [];
        $elementAssignments = ElementAssignment::where('exam_id', $examId)->get();
        foreach($elementAssignments as $ea)
        {
            $score = ElementScore::where('student_id', $studentId)->where('element_assignment_id', $ea->element_assignment_id)->first();
            if( ! empty($score) )
            {
                $scores[] = $score;
            }
        }

        return collect($score);
    }

    /**
     * Records the custom comment text for the student on the element.
     *
     * @param $elementAssignmentId
     * @param $studentId
     * @param $commentText
     * @return ElementScore
     */
    public function recordCommentText($elementAssignmentId, $studentId, $commentText)
    {
        $this->score_object = new ElementScore();
        $this->score_object->element_assignment_id = $elementAssignmentId;
        $this->score_object->student_id = $studentId;
        $this->score_object->recordCommentText($commentText);
        return $this->score_object;
    }

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
    public function record($elementAssignmentId, $studentId, $score)
    {
        return $this->update($elementAssignmentId, $studentId, $score);
    }

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
    public function update($elementAssignmentId, $studentId, $score)
    {
        $this->score_object = new ElementScore();
        $this->score_object->element_assignment_id = $elementAssignmentId;
        $this->score_object->student_id = $studentId;
        $this->score_object->recordScore($score);

//        $this->score_object = ElementScore::updateOrCreate(['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId], ['score' => $score]);
//
//        $this->load($elementAssignmentId, $studentId);
//        $this->score_object->score = $score;
//        $this->score_object->update();
        return $this->score_object;
    }


    /**
     * Deletes the score and comment for a student
     * @param integer $elementAssignmentId
     * @param integer $studentId
     * @return bool
     */
    public function deleteScore($elementAssignmentId, $studentId)
    {
        $score = ElementScore::where('element_assignment_id', $elementAssignmentId)->where('student_id', $studentId)->firstOrFail();
        return $score->delete();
    }

}