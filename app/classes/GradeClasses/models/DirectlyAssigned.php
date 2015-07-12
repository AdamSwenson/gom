<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 10:47 AM
 */

namespace GradeClasses\models;


class DirectlyAssigned implements IGradeHolder
{

    /** @var  \GradeClasses\models\Grade */
    protected $grade;

    public function __call($method, $args)
    {
        return $this->grade->$method($args);
    }

    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param mixed $grade
     */
    public function setGrade(\GradeClasses\models\Grade $grade)
    {
        $this->grade = $grade;
    }


}