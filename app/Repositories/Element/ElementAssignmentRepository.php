<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:49 PM
 */

namespace App\Repositories\Element;


use App\ElementAssignment;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\QuestionAssignmentRepository;
use App\Element;

class ElementAssignmentRepository implements IElementAssignmentRepository
{

    public $assignments;

    /** @var  Exam Holds the exam working on */
    public $exam;

    /** @var ICleanerFactory */
    public $cleaner;

    /** @var  IQuestionAssignmentDAO */
    public $questionAssignmentDao;


    public function __construct()
    {
        $this->questionAssignmentDao = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
//        $this->cleaner = new CleanerFactory();
    }


    public function load_elements($examId, $questionNumber)
    {
        $this->load_element_assignments_by_question_number($examId, $questionNumber);
        $elements = array();
        foreach ($this->assignments as $assign)
        {
            array_push($elements, $assign->element()->first());
        }

        return $elements;
    }

    /**
     * Returns collection of elementAssignment objects associated with a question on an exam.
     * @param $examId
     * @param $questionNumber
     * @return mixed
     */
    public function load_element_assignments_by_question_number($examId, $questionNumber)
    {
        $questionAssignment = $this->questionAssignmentDao->load($examId, $questionNumber);

        if (empty($questionAssignment))
        {
            //TODO: Add error handling
        }
        $this->assignments = ElementAssignment::where('exam_id', $examId)
            ->where('question_id', $questionAssignment->question_id)
            ->get();

        return $this->assignments;
    }

    /**
     * Loads the element assignment object for an element on an exam
     * @param $examId
     * @param $elementId
     */
    public function load_element_assignment_by_element($examId, $elementId)
    {
        return ElementAssignment::where('exam_id', $examId)->where('element_id', $elementId)->first();
    }

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
     * @return array
     */
    public function load_by_exam($examId, $returnArray = false)
    {
        $query = <<<MYSQL
            SELECT ea.id AS element_assignment_id, ea.question_id, ea.element_id, ea.subtask
            FROM element_assignments ea
            INNER JOIN question_assignments qa ON qa.question_id = ea.question_id AND qa.exam_id = ea.exam_id
            WHERE ea.exam_id = :examId
            ORDER BY qa.question_number, ea.subtask
MYSQL;
        $values = ['examId' => $examId];
        $result = \DB::select($query, $values);
        if ($returnArray === true)
        {
            return $result;
        }
        $objects = [];
        foreach ($result as $r)
        {
            $ea = new ElementAssignment();
            $ea->id = $r->element_assignment_id;
            $ea->question_id = $r->question_id;
            $ea->element_id = $r->element_id;
            $ea->exam_id = $examId;
            $ea->subtask = $r->subtask;
            array_push($objects, $ea);
        }

        return collect($objects);
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

        return $element->setAsQuestionTask($examId, $questionId, $subtask);


//      return $element;

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


    /**
     * When recording an element assignment, we need to do a bunch more stuff if
     * the element was already assigned on the exam. This checks if it is already assigned
     * so that other methods can follow the appropriate path.
     *
     * It will return false if the element is not yet assigned. If it has been assigned,
     * this will return the assignment as an ElementAssignment object.
     *
     * @param integer $examId
     * @param integer $elementId
     * @return ElementAssignment|bool
     */
    protected function isElementAlreadyAssignedOnThisExam($examId, $elementId)
    {
        $ea = ElementAssignment::where('exam_id', $examId)->where('element_id', $elementId)->first();
        if (empty($ea))
        {
            return false;
        } else
        {
            return $ea;
        }
    }

    /**
     * When an element is deleted from an exam, the other elements associated with the question will need to be reordered.
     * This returns a collection of elementAssignment objects for the elements which need to be reordered.
     * @param integer $examId
     * @param integer $questionId
     * @param integer $subtaskOfElementBeingDeleted
     * @return bool
     */
    public function reorderElementsToMaintainSubtaskConsistency($examId, $questionId, $subtaskOfElementBeingDeleted)
    {

        $assignments = ElementAssignment::where('exam_id', $examId)
            ->where('question_id', $questionId)
            ->where('subtask', '>', $subtaskOfElementBeingDeleted)
            ->orderBy('subtask')
            ->get();

        /*
        * If $assignments is empty, the element being deleted was set as the last subtask, so
        * we don't need to do anything else. But if it is empty, we need to go through and
        * reduce the assigned subtask by one for each of the elements whose subtask was greater
        * than the subtask of the element being deleted.
        */
        if (!empty($assignments))
        {
            //Do reordering
            foreach ($assignments as $assign)
            {
                $assign->subtask = $assign->subtask - 1;
                $assign->update();
            }
        }
        return true;
    }

    /**
     * Loads array of element ids from the existing element assignments ordered by subtask
     * @param $examId
     * @param $questionId
     * @return int
     */
    public function load_existing_ids_for_element_assignment($examId, $questionId)
    {
        $query = <<<MYSQL
            SELECT element_id
            FROM element_assignments
            WHERE exam_id = :examId AND question_id = :questionId
            ORDER BY subtask
MYSQL;
        $values = ['examId' => $examId, 'questionId' => $questionId];
        $existingElements = \DB::select($query, $values);

        /* Check whether any elements have been assigned for the question  */
        if (empty($existingElements) || count($existingElements) == 0)
        {
            return self::CASE_ADDITION;
        }

        return $existingElements;
    }




}