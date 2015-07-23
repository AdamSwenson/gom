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
     * Create a new element and associated comments
     * @param $elementName
     * @param $respGeneric
     * @param $respAbsent
     * @param $respPoor
     * @param $respFair
     * @param $respGood
     * @return Element
     */
    public function createElement($elementName, $respGeneric, $respAbsent, $respPoor, $respFair, $respGood)
    {
        $element = $this->dao->createElement($elementName, '', $respGeneric);
        if(!empty($element))
        {
            //this needs an element assignment

            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_ABSENT, $respAbsent);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_POOR, $respPoor);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_OK, $respFair);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_EXCELLENT, $respGood);
        }
        return $element;
    }

    /**
     * Delete an element from the database.
     * Also deletes all associated scores and comments.
     * @param integer $elementId
     * @return mixed
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