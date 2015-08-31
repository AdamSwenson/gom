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
     * Will return array of arrays which have keys:
     *      questionId: The id of the question
     *      questionNumber: The order the question appears on the exam
     *      questionName: The name of the question
     *      questionAssignmentId: The id of the assignment of the question to the exam
     *      questionScore: Float of the score the student received on this question. (Null if not answered)
     *
     * @param $examId
     * @param $studentId
     */
    public function load_for_student_on_exam($examId, $studentId)
    {
        $query = <<<MYSQL
        SELECT q.id AS questionId,
            qa.question_number AS questionNumber,
            q.questionName,
            qa.id AS questionAssignmentId,
            (SELECT qs.score AS questionScore
                FROM question_scores qs
                WHERE qs.student_id = :studentId
                    AND qs.question_assignment_id = questionAssignmentId
            ) AS questionScore
        FROM questions q
        INNER JOIN question_assignments qa ON q.id = qa.question_id
        WHERE qa.exam_id = :examId
            AND q.user_id = :userId
        ORDER BY qa.question_number ASC;
MYSQL;

    //    $query = "CALL get_question_scores_for_student(:userId, :examId, :studentId)";
        $values = [
            'userId' => \Auth::user()->id,
            'examId' => $examId,
            'studentId' => $studentId,
        ];
        return \DB::select($query, $values);
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
    public function record($questionAssignmentId, $studentId, $score)
    {
        return $this->update($questionAssignmentId, $studentId, $score);
    }

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
    public function update($questionAssignmentId, $studentId, $score)
    {
        $questionScore = new QuestionScore();
        $questionScore->question_assignment_id = $questionAssignmentId;
        $questionScore->student_id = $studentId;
        $questionScore->recordScore($score);
        return $questionScore;

        /*
        $this->load($questionAssignmentId, $studentId);
        if (!empty($this->score_object))
        {
            $this->score_object->setScore($score);
            $this->score_object->update();
            return $this->score_object;
        }
        else{
            $questionScore = new QuestionScore();
            $questionScore->question_assignment_id = $questionAssignmentId;
            $questionScore->student_id = $studentId;
            $questionScore->score = $score;
            $questionScore->save();
            return $questionScore;
        }*/
    }


    /**
     * Deletes a question score for a student
     * @param integer $questionAssignmentId
     * @param integer $studentId
     * @return boolean
     */
    public function deleteScore($questionAssignmentId, $studentId)
    {
        $score = QuestionScore::where('question_assignment_id', $questionAssignmentId)->where('student_id', $studentId)->firstOrFail();
        return $score->delete();
    }


}