<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 8:39 AM
 */

namespace App\classes\OutputClasses\facades;


interface IVisitor 
{

    static public function make(\Exam $exam, \Student $student);

    public function examID();

    public function studentID();

    public function studentName();
}