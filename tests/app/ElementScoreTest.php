<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 2:19 PM
 */

namespace App;


/**
 * @property mixed score
 */
class ElementScoreTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ElementScore;
        $this->score = ElementScore::all()->random(1);
    }

    public function testScopeOnStudent()
    {
        $s = $this->score->toArray();
        $result = $this->object->onStudent($s['student_id']);
        $this->assertNotEmpty($result);
    }


    public function testScopeOnElementAssignment()
    {
        $s = $this->score->toArray();
        $result = $this->object->onElementAssignment($s['element_assignment_id']);
        $this->assertNotEmpty($result);

    }

    public function testScopeOnStudentElementAssignment()
    {
        $s = $this->score->toArray();
        $result = $this->object->onStudentElementAssignment($s['student_id'], $s['element_assignment_id']);
        $this->assertNotEmpty($result);
    }

#------------------------------------- getters and setters
    public function testGetScore()
    {
        $expect = $this->score->score;
        $this->assertEquals($expect, $this->score->getScore());
    }


    public function testSetScore()
    {
        $test = 4.56;
        $this->object->setScore($test);
        $this->assertEquals($test, $this->object->score);
    }

    #---------------------------------------- foreign keys

    public function testElement()
    {
        foreach ($this->score->element as $r)
        {
            $this->assertInstanceOf('App\Element', $r);
        }
    }

//    public function testExam()
//    {
//        $this->assertInstanceOf('App\Exam', $this->score->exam);
//    }


//    public function testUser()
//    {
//        $this->assertInstanceOf('App\User', $this->score->user);
//    }

//
//    public function testQuestion()
//    {
//        $this->assertInstanceOf('App\Question', $this->score->question);
//    }

    public function testStudent()
    {
        foreach($this->score->students as $s)
        {
            $this->assertInstanceOf('App\Student', $s);
        }

    }

    public function testElementAssignment()
    {
        $this->assertInstanceOf('App\ElementAssignment', $this->score->elementAssignment);
    }

}
