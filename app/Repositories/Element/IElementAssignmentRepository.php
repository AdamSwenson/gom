<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:56 PM
 */
namespace App\Repositories\Element;

interface IElementAssignmentRepository
{
    /**
     * Loads the elements for a given question
     * (returns an array of element objects)
     * @param $examId
     * @param $questionNumber
     * @return array
     */
    public function load_elements($examId, $questionNumber);

    /**
     * Loads the element assignments for a given question
     * (returns an array of elementAssignment objects)
     * @param $examId
     * @param $questionNumber
     * @return array
     */
    public function load_element_assignments_by_question_number($examId, $questionNumber);


    /**
     * Loads all elements on an exam. By default, will return a laravel collection of ElementAssignment objects
     *
     * If $returnArray is set to true, these will be returned in an array of StdClass objects. Each object will have the properties:
     *      element_assignmentId,
     *      question_id,
     *      element_id,
     *      subtask
     *
     * The objects will be in ascending order by question number and subtask
     * For example: [
     *      question 1 subtask 1,
     *      question 1 subtask 2,
     *      ....
     *      question 2 subtask 1,
     *      ....
     *      question 3 subtask 1
     *      ....
     *      ]
     *
     * @param integer $examId
     * @param bool $returnArray
     * @return array|Collection
     */
    public function load_by_exam($examId, $returnArray=false);

    /**
     * Loads the element assignment object for an element on an exam
     * @param integer $examId
     * @param integer $elementId
     */
    public function load_element_assignment_by_element($examId, $elementId);

    /**
     * Records new element assignment to question
     * @param $examId
     * @param $questionId
     * @param $elementId
     * @param $subtask
     * @return \Element
     */
    public function record($examId, $questionId, $elementId, $subtask);
}