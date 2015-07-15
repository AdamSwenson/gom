<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 11:22 AM
 */

namespace App\classes\GradeClasses\service;


class GradeMakerTest extends \TestCase {

    public $displayNumeric;
    public $displayText;
    protected $object;
    
    public function setUp()
    {
        $this->displayText = 'TestText';
        $this->displayNumeric = 88.5;
        parent::setUp();
//        $this->object = new GradeMaker;
    }

    public function testCalculated()
    {
        $this->object = GradeMaker::factory(GradeMaker::CALCULATED);
        $this->assertInstanceOf('App\classes\GradeClasses\models\CalculatedGrade', $this->object);
    }

    public function testCalculatedArgs()
    {
        $max = 34.4;
        $min = 12.3;
        $this->object = GradeMaker::factory(GradeMaker::CALCULATED,
            $this->displayText,
            $this->displayNumeric,
            array(\App\classes\GradeClasses\models\CalculatedGrade::MAX_SCORE_KEY => $max,
            \App\classes\GradeClasses\models\CalculatedGrade::MIN_SCORE_KEY => $min)
        );
        $this->assertInstanceOf('App\classes\GradeClasses\models\CalculatedGrade', $this->object);
        $this->assertAttributeInstanceOf('App\classes\GradeClasses\models\Grade', 'grade', $this->object);
        $this->assertEquals($this->displayText, $this->object->getGrade()->getDisplayText());
        $this->assertEquals($this->displayNumeric, $this->object->getGrade()->getDisplayNumeric());
        $this->assertEquals($max, $this->object->getMaxScore());
        $this->assertEquals($min, $this->object->getMinScore());
    }

    public function testDirect()
    {
        $this->object = GradeMaker::factory(GradeMaker::DIRECT);
        $this->assertInstanceOf('App\classes\GradeClasses\models\DirectlyAssigned', $this->object);
    }

    public function testDirectArgs()
    {
        $this->object = GradeMaker::factory(GradeMaker::DIRECT,
            $this->displayText,
            $this->displayNumeric
        );
        $this->assertInstanceOf('App\classes\GradeClasses\models\DirectlyAssigned', $this->object);
        $this->assertAttributeInstanceOf('App\classes\GradeClasses\models\Grade', 'grade', $this->object);
        $this->assertEquals($this->displayText, $this->object->getGrade()->getDisplayText());
        $this->assertEquals($this->displayNumeric, $this->object->getGrade()->getDisplayNumeric());
    }
}
