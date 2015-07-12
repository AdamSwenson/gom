<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:40 PM
 */

namespace StudentClasses\dao;


interface IStudentLoader 
{

    public function load_students_by_exam(\Exam $exam);

}