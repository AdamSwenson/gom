<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 6:03 PM
 */

namespace App\classes\RequestHandlers\workers;

class QuestionWorker extends IRequestWorker {

    // NOTE: we may need a method to set the order that questions appear

    public function getQuestion($questionId){

    }

    public function getAllQuestions($classId = null){
        // if $classId = null, return all Questions related to user
    }

    public function createQuestion($questionName, $questionDesc, $order, $examId) {}

    public function deleteQuestion($questionId) {}

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }
}