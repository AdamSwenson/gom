<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 6:03 PM
 */

namespace App\classes\RequestHandlers\workers;

class ElementWorker extends IRequestWorker {

// NOTE: we may need a method to set the order that questions appear

    public function getElement($elementId){
    }

    public function getAllElements($questionId){
        //
    }

    public function createElement($elementName, $respGeneric, $respAbsent, $respPoor, $respFair, $respGood) {}

    public function deleteElement($elementId) {}

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }
}