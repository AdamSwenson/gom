<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/22/15
 * Time: 10:17 AM
 */

namespace App\classes\RequestHandlers\dao;


use App\classes\MockParent;
use App\classes\RequestHandlers\dao\IElementDAO;

class IElementDAOMock extends MockParent implements IElementDAO
{


    public function loadElementById($elementId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($elementId));
        return $this->response;
    }


    public function createElement($elementName, $displayText, $commentText)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($elementName, $displayText, $commentText));
        return $this->response;
    }


    public function deleteElement($elementId)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($elementId));
        return $this->response;
    }


    public function editElement($elementId, $elementName, $displayText, $commentText)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($elementId, $elementName, $displayText, $commentText));
        return $this->response;
    }

    public function addValencedContent($elementId, $valence, $content)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($elementId, $valence, $content));
        return $this->response;
    }
}