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
     * Will return array of stdClass objects which has properties:
     *      questionId: The id of the question
     *      questionNumber: The order the question appears on the exam
     *      questionName: The name of the question
     *      questionAssignmentId: The id of the assignment of the question to the exam
     *      questionScore: Float of the score the student received on this question. (Null if not answered)
     *
     * NOTE: actually returning array of objects: must be accessed by item->value !! (bb 9/20)
     *
     * @param $examId
     * @param $studentId
     * @return array of objects
     */
    public function load_for_student_on_exam($examId, $studentId)
    {
        $query = <<<MYSQL
        SELECT q.id AS questionId,
            qa.question_number AS questionNumber,
            q.questionName,
            qa.id AS questionAssignmentId,
            qs.score AS questionScore
        FROM questions q
        INNER JOIN question_assignments qa ON q.id = qa.question_id
        INNER JOIN question_scores qs ON qa.id = qs.question_assignment_id
        WHERE qa.exam_id = :examId
            AND q.user_id = :userId
            AND qs.student_id = :studentId
        ORDER BY qa.question_number ASC;
MYSQL;

//        $query = <<<MYSQL
//        SELECT q.id AS questionId,
//            qa.question_number AS questionNumber,
//            q.questionName,
//            qa.id AS questionAssignmentId,
//            (SELECT qs.score AS questionScore
//                FROM question_scores qs
//                WHERE qs.student_id = :studentId
//                    AND qs.question_assignment_id = questionAssignmentId
//            ) AS questionScore
//        FROM questions q
//        INNER JOIN question_assignments qa ON q.id = qa.question_id
//        WHERE qa.exam_id = :examId
//            AND q.user_id = :userId
//        ORDER BY qa.question_number ASC;
//MYSQL;

        //    $query = "CALL get_question_scores_for_student(:userId, :examId, :studentId)";
        $values = [
            'userId'    => \Auth::user()->id,
            'examId'    => $examId,
            'studentId' => $studentId,
        ];

        return \DB::select($query, $values);
    }

    /**
     * Returns the total of all question scores for the student on the exam.
     * Will return 0 if there are no scores recorded for the student.
     * @param $examId
     * @param $studentId
     * @return int|float
     */
    public function load_total_for_student_on_exam($examId, $studentId)
    {
        $total = 0;
        $studentScores = $this->load_for_student_on_exam($examId, $studentId);
        foreach ( $studentScores as $score )
        {
            $total += $score->questionScore;
        }

        return $total;
    }

    /**
     * Loads all scores for a given question on an exam.
     * This returns an array of stdClass objects, each of which has a score property.
     * So to access the score of the first item you would do $result[0]->score
     * @param $examId
     * @param $questionNumber
     * @return array of StdClass objects
     */
    public function load_all_for_question_number($examId, $questionNumber)
    {
        $query = <<<MYSQL
        SELECT score
        FROM question_scores qs INNER JOIN question_assignments qa ON qs.`question_assignment_id` = qa.id
        WHERE qa.exam_id = :examId
        AND qa.question_number = :questionNumber
MYSQL;
        $values = [
            'examId'         => $examId,
            'questionNumber' => $questionNumber,
        ];

        return \DB::select($query, $values);
    }

    /**
     * Loads all scores for a given question on an exam.
     * This returns an array of stdClass objects, each of which has a score property.
     * So to access the score of the first item you would do $result[0]->score
     * @param integer $examId
     * @param integer $questionId
     * @return array of StdClass objects
     */
    public function load_all_for_question_id($examId, $questionId)
    {
        $query = <<<MYSQL
        SELECT score
        FROM question_scores qs INNER JOIN question_assignments qa ON qs.`question_assignment_id` = qa.id
        WHERE qa.exam_id = :examId
        AND qa.question_id = :questionId
MYSQL;
        $values = [
            'examId'         => $examId,
            'questionNumber' => $questionId,
        ];

        return \DB::select($query, $values);
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