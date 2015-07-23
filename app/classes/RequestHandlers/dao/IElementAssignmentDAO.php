<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/22/15
 * Time: 4:35 PM
 */
namespace App\classes\RequestHandlers\dao;


/**
 * Class ElementAssignmentDAO
 * Handles almost all database interactions with the elementsXquestions table
 *
 * @package App\classes\RequestHandlers\dao
 */
interface IElementAssignmentDAO
{
    /**
     * Loads the elements for a given question
     * (returns an array of question objects)
     * @param $examId
     * @param $questionId
     */
    public function load_elements($examId, $questionId);

    public function load_by_exam($examId);

    /**
     * Records new element assignment to question
     * @param $examId
     * @param $questionId
     * @param $elementId
     * @param $subtask
     * @return \ElementAssignment
     */
    public function record($examId, $questionId, $elementId, $subtask);
}