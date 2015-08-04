<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:49 PM
 */

namespace App\Repositories\Element;


use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\classes\SecurityClasses\cleaning\ICleanerFactory;
use App\ElementAssignment;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\QuestionAssignmentRepository;
use App\Element;

class ElementAssignmentRepository implements IElementAssignmentRepository
{

    public $assignments;

    /** @var ICleanerFactory */
    public $cleaner;

    /** @var  IQuestionAssignmentDAO */
    public $questionAssignmentDao;

    /**
     * TODO Fix dependency injection
     */
    public function __construct()
    {
        $this->questionAssignmentDao = new QuestionAssignmentRepository();
        $this->cleaner = new CleanerFactory();
    }

//    public function __construct(IQuestionAssignmentRepository $questionAssignmentDao, ICleanerFactory $cleaner)
//    {
//        $this->questionAssignmentDao = $questionAssignmentDao;
//        $this->cleaner = $cleaner;
//    }

    public function setCleaner(ICleanerFactory $cleanerFactory)
    {
        $this->cleaner = $cleanerFactory;
    }


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
        foreach ($this->assignments as $assign)
        {
            array_push($elements, $assign->element()->first());
        }
        return $elements;
    }

    public function load_element_assignments_by_question_number($examId, $questionNumber)
    {
        $questionAssignment = $this->questionAssignmentDao->load($examId, $questionNumber);

        if (empty($questionAssignment))
        {
            //TODO: Add error handling
        }
        $this->assignments = ElementAssignment::where('question_assignment_id', $questionAssignment->id)->get();

        return $this->assignments;
    }

    public function load_by_exam($examId)
    {
        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($examId);

        return ElementAssignment::where('question_assignment_id', $questionAssignments)->get();
    }

    /**
     * Record the assignment of an element to an assigned question as a particular subtask
     * @param $examId
     * @param $questionId
     * @param $elementId
     * @param $subtask
     * @return Element
     */
    public function record($examId, $questionId, $elementId, $subtask)
    {
        $element = Element::findOrFail($elementId);
        $element->setAsQuestionTask($examId, $questionId, $subtask);
      return $element;

//        $questionAssignment = $this->questionAssignmentDao->loadQuestionNumberById($examId, $questionId);
//
//        $ea = ElementAssignment::where('question_assignment_id', $questionAssignment->id)->where('subtask', $subtask);
//        if($ea){
//            $ea->delete();
//        }
////        $assign = new ElementAssignment();
//        $assign = ElementAssignment::firstOrNew(['question_assignment_id' => $questionAssignment->getId(), 'elementId']);
//        $assign->element()->associate($elementId);
//        $assign->questionAssignment()->associate($questionAssignment);
//        $assign->setSubtask($subtask);
//        $assign->save();
//
//        return $assign;
    }
}