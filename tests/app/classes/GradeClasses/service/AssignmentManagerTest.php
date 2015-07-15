<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 12:59 PM
 */

namespace App\classes\GradeClasses\service;


class AssignmentManagerTest extends \TestCase {

    public $direct_grade_objects;
    public $calc_grade_objects;
    public $grade_objects;
    protected $object;
    
    public function setUp()
    {
        $this->numObj = 10;

        parent::setUp();
        $this->object = new AssignmentManager;

        if(!isset($this->grade_objects) || !isset($this->calc_grade_objects) || !isset($this->direct_grade_objects))
        {
            $this->prepare();
        }

    }

    public function prepare()
    {
        $this->grade_objects = array();
        $this->calc_grade_objects = array();
        $this->direct_grade_objects = array();


        for($i=0; $i < $this->numObj; $i++){
            $g = new \App\classes\GradeClasses\models\Grade();
            $g->setSortOrder($i);

            $go = new \App\classes\GradeClasses\models\CalculatedGrade();
            $go->setGrade(clone $g);
            array_push($this->calc_grade_objects, $go);

            $dg = new \App\classes\GradeClasses\models\DirectlyAssigned();
            $dg->setGrade(clone $g);
            array_push($this->direct_grade_objects, $dg);

            array_push($this->grade_objects, $g);
        }

        shuffle($this->grade_objects);
        shuffle($this->direct_grade_objects);
        shuffle($this->calc_grade_objects);

    }

    public function orderTest($array)
    {
        for($i=0; $i < $this->numObj; $i++){
            $this->assertEquals($i, $array[$i]->getSortOrder());
        }
    }

    public function testAddGradesArray()
    {
        $this->object->addGrades($this->grade_objects);
        $ar = $this->object->getGrades();
        $this->assertTrue(is_array($ar));
        $this->orderTest($ar);
    }

    public function testAddGradesCalcArray()
    {
        $this->object->addGrades($this->calc_grade_objects);
        $this->orderTest($this->object->getGrades());
    }

    public function testAddGradesDirectArray()
    {
        $this->object->addGrades($this->direct_grade_objects);
        $this->orderTest($this->object->getGrades());
    }

    public function testAddGradesIndividuals()
    {
     foreach($this->grade_objects as $g) {
         $this->object->addGrades($g);
     }
        $this->orderTest($this->object->getGrades());
    }

    public function testAddCalcGradesIndividuals()
    {
        foreach($this->calc_grade_objects as $g) {
            $this->object->addGrades($g);
        }
        $this->orderTest($this->object->getGrades());
    }
    public function testAddDirectGradesIndividuals()
    {
        foreach($this->direct_grade_objects as $g) {
            $this->object->addGrades($g);
        }
        $this->orderTest($this->object->getGrades());
    }

}
