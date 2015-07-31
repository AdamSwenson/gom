<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 12:53 PM
 */

namespace App\classes\RequestHandlers\dao;

use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\classes\SecurityClasses\cleaning\ICleanerFactory;
use App\ElementAssignment;


/**
 * Class ElementAssignmentDAO
 * Handles almost all database interactions with the elementsXquestions table
 *
 * @package App\classes\RequestHandlers\dao
 */
class ElementAssignmentDAO implements IElementAssignmentDAO
{
    public $assignments;

    /** @var ICleanerFactory  */
    public $cleaner;

    /** @var  IQuestionAssignmentDAO */
    public $questionAssignmentDao;

    public function __construct()
    {
        $this->cleaner = new CleanerFactory();
        $this->questionAssignmentDao = new QuestionAssignmentDAO();
    }

    public function setCleaner(ICleanerFactory $cleanerFactory)
    {
        $this->cleaner = $cleanerFactory;
    }


    /**
     * Loads the elements for a given question
     * (returns an array of element objects)
     * @param $examId
     * @param $questionNumber
     * @return array
     */
    public function load_elements($examId, $questionNumber)
    {
//        $questionAssignment = $this->questionAssignmentDao->load($examId, $questionNumber);
//
//        if(empty($questionAssignment))
//        {
//        //TODO: Add error handling
//        }
//        $this->assignments = ElementAssignment::where('question_assignment_id', $questionAssignment[0]->id)->get();
        $this->load_element_assignments_by_question_number($examId, $questionNumber);
        $elements = array();
        foreach($this->assignments as $assign)
        {
            array_push($elements, $assign->element()->first());
        }
        return $elements;
    }

    /**
     * Loads the elements for a given question
     * (returns an array of element objects)
     * @param $examId
     * @param $questionNumber
     * @return array
     */
    public function load_element_assignments_by_question_number($examId, $questionNumber)
    {
        $questionAssignment = $this->questionAssignmentDao->load($examId, $questionNumber);

        if(empty($questionAssignment))
        {
            //TODO: Add error handling
        }
        $this->assignments = ElementAssignment::where('question_assignment_id', $questionAssignment[0]->id)->get();
        return $this->assignments;
    }

    /**
     * Load all element assignments for the exam.
     *
     * TODO Set up eager loading of elements
     *
     * @param $examId
     * @return mixed
     */
    public function load_by_exam($examId)
    {
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($examId);
        return ElementAssignment::where('question_assignment_id', $questionAssignments)->get();
    }

    /**
     * Records new element assignment to question
     * @param $examId
     * @param $questionId
     * @param $elementId
     * @param $subtask
     * @return \ElementAssignment
     */
    public function record($examId, $questionId, $elementId, $subtask)
    {
        $questionAssignment = $this->questionAssignmentDao->loadByIds($examId, $questionId);
        $assign = new ElementAssignment();
        $assign->element()->associate($elementId);
        $assign->questionAssignment()->associate($questionAssignment[0]);
        $assign->setSubtask($subtask);
        $assign->save();
        return $assign;
    }
}
