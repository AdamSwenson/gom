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
     * Load all element assignments for the exam.
     *
     * TODO Set up eager loading of elements
     *
     * @param $examId
     * @return mixed
     */
    public function load_by_exam($examId);

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