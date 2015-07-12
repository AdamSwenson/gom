<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 10:51 AM
 */

namespace QuestionClasses\dao;


interface IQuestionDAO
{

    /**
     * Loads a question object from an array
     * @param array $incoming
     * @return \Question
     */
    public function get_question_from_array(array $incoming);

    /**
     * Handles getting a new question object to deal with the various legal
     * incoming arrays.
     * @param int $questionID
     * @return Question
     */
    public function get_question($questionID);

    /**
     * Fills a question with content from incoming
     * @param \Question $question
     * @param array $incoming
     * @return \Question
     */
    public function load_question_content(\Question $question, array $incoming);

}