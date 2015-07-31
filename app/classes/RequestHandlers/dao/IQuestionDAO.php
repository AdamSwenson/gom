<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 10:51 AM
 */

namespace App\classes\RequestHandlers\dao;


interface IQuestionDAO
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
     * Handles getting a new question object. Throws exception if does not exist
     * @param int $questionId
     * @return Question
     */
    public function loadQuestionById($questionId);

    /**
     * Load all questions for the user
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function loadAll();

    public function loadQuestionsByClassId($classId);
}