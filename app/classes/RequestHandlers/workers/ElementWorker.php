<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 6:03 PM
 */

namespace App\classes\RequestHandlers\workers;

use App\classes\RequestHandlers\dao\IElementAssignmentDAO;
use App\classes\RequestHandlers\dao\IElementDAO;
use App\classes\RequestHandlers\dao\ElementAssignmentDAO;
use App\classes\RequestHandlers\dao\ElementDAO;
use App\Comment;
use App\Element;

/**
 * Class ElementWorker
 * Handles creating, updating, and deleting elements, along
 * with assignments to questions, and comment management.
 *
 * NOTE: we may need a method to set the order that questions appear
 *
 * @package App\classes\RequestHandlers\workers
 */
class ElementWorker extends IRequestWorker
{
    /** @var IElementDAO  */
    public $dao;

    /** @var IElementAssignmentDAO  */
    public $assignmentDao;

    public function __construct()
    {
        $this->dao = new ElementDAO();
        $this->assignmentDao = new ElementAssignmentDAO();
    }

    /**
     * Loads an element from its id
     * @param integer $elementId
     * @return Element
     */
    public function getElement($elementId)
    {
        $element = $this->dao->loadElementById($elementId);
        return $element;
    }

    /**
     * Loads all elements for the belonging to the user.
     * If question id is set, get only those which have been assigned to a question
     *
     * TODO: Set up for question after confirming this is the intended request. (What would we do with every element that has ever been assigned to a question?)
     * @param integer $questionId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllElements($questionId=null)
    {
        if(!empty($questionId))
        {}
        else{
            return Element::all();
        }
    }

    /**
     * Returns a collection of ElementAssignment objects (which have the subtask as a property)
     * and the actual elements in a collection property.
     *
     * So, for example, if you wanted to display the elements for question number 2 on exam 3, you would do:
     *  $elementAssignments = self::getElementAssignmentsForQuestionNumber(3, 2);
     *  foreach($elementAssignments as $ea)
     *  {
     *      $ea->subtask;
     *      $ea->element->elementName;
     *  }
     *
     * @param $examId
     * @param $questionNumber
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getElementAssignmentsForQuestionNumber($examId, $questionNumber)
    {
        return $this->dao->load_element_assignments_by_question_number($examId, $questionNumber);
    }

    /**
     * Create a new element and associated comments.
     *
     * @param integer $examId  The exam number to associate the element with
     * @param integer $questionNumber  The question number on the exam (NB, not the id) the element belongs to.
     * @param integer $subtask  The order in which the element should appear within the question.
     * @param string $elementName  The name of the element.
     * @param string $respGeneric  The base comment text.
     * @param string $respAbsent  The text of the comment for the absent case.
     * @param string $respPoor  The text of the comment for the poor case.
     * @param string $respFair  The text of the comment for the fair case.
     * @param string $respGood  The text of the comment for the good case.
     * @return Element
     */
    public function createElement($examId, $questionNumber, $subtask, $elementName, $respGeneric, $respAbsent, $respPoor, $respFair, $respGood)
    {
        $element = $this->dao->createElement($elementName, '', $respGeneric);
        if(!empty($element))
        {
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_ABSENT, $respAbsent);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_POOR, $respPoor);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_OK, $respFair);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_EXCELLENT, $respGood);

            $this->assignmentDao->record($examId, $questionNumber, $element->getId(), $subtask);
        }
        return $element;
    }

    /**
     * Delete an element from the database.
     * Also deletes all associated scores and comments.
     *
     * @param integer $elementId
     * @return boolean
     */
    public function deleteElement($elementId)
    {
        return $this->dao->deleteElement($elementId);
    }

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }
}