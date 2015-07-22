<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 6:03 PM
 */

namespace App\classes\RequestHandlers\workers;

class StudentWorker extends IRequestWorker {
    
    public function getStudent($studentId){
    }

    public function getAllStudents($examId){
        //
    }

    public function createStudent($lastName, $firstName, $studentId, $examId) {}

    public function deleteStudent($studentId) {}

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }
}