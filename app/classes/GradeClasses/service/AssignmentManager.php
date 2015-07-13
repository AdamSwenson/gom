<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 12:16 PM
 */

namespace App\classes\GradeClasses\service;


class AssignmentManager 
{

    public $validator;

    protected $grades = array();

    /**
     * Returns array holding all the grades sorted by
     * each grade's sortOrder.
     * @return array
     */
    public function getGrades()
    {
        $this->sort();
        return $this->grades;
    }


    /**
     * Adds \IGradeHolder objects or \Grade objects to
     * the list of grades. Can either add a single object
     * or an array of them.
     * @param $grade_or_array_of_grades
     */
    public function addGrades($grade_or_array_of_grades)
    {
        if(is_array($grade_or_array_of_grades)){
            $this->grades += $grade_or_array_of_grades;
        }else{
            array_push($this->grades, $grade_or_array_of_grades);
        }
    }


    public function sort()
    {
        usort($this->grades, function($a, $b) {
            return $a->getSortOrder() - $b->getSortOrder();
        });
    }
}