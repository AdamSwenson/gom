<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 5:19 PM
 */
namespace App\Repositories\Question;

use App\Question;


/**
 * Class QuestionRepository
 *
 * Replaces IQuestionDao
 *
 * @package Repositories\Question
 */
interface IQuestionRepository
{
    /**
     * Creates a new question
     * @param string $questionName
     * @param string $questionText
     * @return Question
     */
    public function createQuestion($questionName, $questionText);

    /**
     * Delete a question from the database (and from any exams it is associated with).
     * Note: Also removes any existing question scores or element scores.
     * @param integer $questionId
     * @return int
     */
    public function deleteQuestion($questionId);

    /**
     * Delete a question from the database (and from any exams it is associated with).
     * Note: Also removes any existing question scores or element scores.
     * @param Question $question
     * @return int
     */
    public function deleteQuestionObject(Question $question);

    /**
     * Updates a question on the basis of its id
     * @param $questionId
     * @param string $questionName
     * @param string $questionText
     * @return Question
     */
    public function updateQuestion($questionId, $questionName, $questionText);


    /**
     * Updates a question when the model has been passed in
     * @param Question $question
     * @param string $questionName
     * @param string $questionText
     * @return Question
     */
    public function updateQuestionObject(Question $question, $questionName, $questionText);

    /**
     * Load all questions for the user
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function loadAll();

    /**
     * Handles getting a new question object. Throws exception if does not exist
     * @param int $questionId
     * @return Question
     */
    public function loadQuestionById($questionId);

    public function loadQuestionsByClassId($classId);
}