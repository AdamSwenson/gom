<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 2:02 PM
 */

namespace App\classes\GradeClasses\service;


class GradeValidatorTest extends \TestCase
{
    public $direct_grade_objects;
    public $calc_grade_objects;
    public $grade_objects;
    protected $object;

//    protected $object;
//    public static $grade_objects = array();
//    public static $calc_grade_objects = array();
//    public static $direct_grade_objects = array();

    public function setUp()
    {
        $this->numObj = 10;
        parent::setUp();
        $this->object = new GradeValidator;
//        if (!empty(self::$grade_objects) || !empty(self::$calc_grade_objects) || !empty(self::$direct_grade_objects)) {
//            $this->prepare();
//        }

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

    for ($i = 0; $i < $this->numObj; $i++) {
        $g = new \App\classes\GradeClasses\models\Grade();
        $g->setSortOrder($i);

        $go = new \App\classes\GradeClasses\models\CalculatedGrade();
        $go->setGrade(clone $g);
        array_push($this->calc_grade_objects, $go);
//
//        $dg = new \App\classes\GradeClasses\models\DirectlyAssigned();
//        $dg->setGrade(clone $g);
//        array_push($this->direct_grade_objects, $dg);

        array_push($this->grade_objects, $g);
    }

    shuffle($this->grade_objects);
    shuffle($this->direct_grade_objects);
    shuffle($this->calc_grade_objects);
}

    public function testCheckTransitiveGood()
    {
//        $ars = array($this->grade_objects, $this->direct_grade_objects, $this->calc_grade_objects);
//        foreach($ars as $ar)
//        {
            $i = 1;
            $ar = array_reverse($this->calc_grade_objects);
            foreach($ar as $a)
            {
                $a->setMinScore($i += 0.25);
                $a->setMaxScore($i += 1.3);
                $i++;
            }
            $ar = array_reverse($ar);
            $this->assertTrue($this->object->checkTransitive($ar));
//        }
    }


    //    public function prepare()
//    {
//
//        for ($i = 0; $i < $this->numObj; $i++) {
//            $g = new \App\classes\GradeClasses\models\Grade();
//            $g->setSortOrder($i);
//
//            $go = new \App\classes\GradeClasses\models\CalculatedGrade();
//            $go->setGrade(clone $g);
//            array_push(self::$calc_grade_objects, $go);
//
//            $dg = new \App\classes\GradeClasses\models\DirectlyAssigned();
//            $dg->setGrade(clone $g);
//            array_push(self::$direct_grade_objects, $dg);
//
//            array_push(self::$grade_objects, $g);
//        }
//
//        shuffle(self::$grade_objects);
//        shuffle(self::$direct_grade_objects);
//        shuffle(self::$calc_grade_objects);
//    }

}
