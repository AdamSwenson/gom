<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 1:11 PM
 */

namespace App\classes\RequestHandlers\dao;



use App\Exam;
use App\Question;
use App\QuestionAssignment;

/**
 * Class QuestionAssignmentDAO
 * Handles establishing, updating, and removing associations between questions and exams
 *
 * @package App\classes\RequestHandlers\dao
 */
class QuestionAssignmentDAO implements IQuestionAssignmentDAO
{

    /**
     * Loads and returns a question assignment
     * TODO: Add eager loading of question
     *
     * @param $examId
     * @param $question_number
     * @return QuestionAssignment
     */
    public function load($examId, $question_number)
    {
        return QuestionAssignment::onExam($examId)->questionNumber($question_number)->get();
    }

    /**
     * Assigns a question to an exam as the specified question number
     * TODO: Add eager loading of question
     * @param Exam $examId
     * @param Question $questionId
     * @param $question_number
     * @return QuestionAssignment
     */
    public function record($examId, $questionId, $question_number)
    {
        $qa = QuestionAssignment::onExam($examId)->questionNumber($question_number)->firstOrNew();
        $qa->question()->save($questionId);
        return $qa;
    }

    /**
     * Gets questions for exam, ordered by question number
     * Returns a collection of QuestionAssignment objects.
     * TODO: Add eager loading of question
     *
     * @param $examId
     * @return
     *
     */
    public function load_all_for_exam($examId)
    {
        return QuestionAssignment::onExam($examId)->orderBy('questionNumber')->get();
    }

    /**
     * Removes the assignment of a question to an exam
     * @param $examId
     * @param $questionId
     * @return mixed
     */
    function remove($examId, $questionId)
    {
        $qa = QuestionAssignment::onExam($examId)->question($questionId)->firstOrFail();
        return $qa->delete();
    }
}