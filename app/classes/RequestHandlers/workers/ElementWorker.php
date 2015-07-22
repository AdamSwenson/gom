<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 6:03 PM
 */

namespace App\classes\RequestHandlers\workers;

use App\classes\RequestHandlers\dao\ElementDAO;

class ElementWorker extends IRequestWorker
{

// NOTE: we may need a method to set the order that questions appear
    public $dao;

    public function __construct()
    {
        $this->dao = new ElementDAO();
    }

    public function getElement($elementId)
    {
        $element = $this->dao->loadElementById($elementId);
        return $element;
    }

    public function getAllElements($questionId)
    {
        //
    }

    public function createElement($elementName, $respGeneric, $respAbsent, $respPoor, $respFair, $respGood)
    {
        $element = $this->dao->createElement($elementName, '', $respGeneric);
        if(!empty($element))
        {
            $this->dao->addValencedContent($element->id, ElementDAO::VALENCE_ABSENT, $respAbsent);
            $this->dao->addValencedContent($element->id, ElementDAO::VALENCE_POOR, $respPoor);
            $this->dao->addValencedContent($element->id, ElementDAO::VALENCE_OK, $respFair);
            $this->dao->addValencedContent($element->id, ElementDAO::VALENCE_EXCELLENT, $respGood);
        }

    }

    public function deleteElement($elementId)
    {
        return $this->dao->deleteElement($elementId);
    }

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }
}