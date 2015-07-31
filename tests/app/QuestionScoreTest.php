<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 11:09 AM
 */

namespace App;


/**
 * @property mixed score
 */
class QuestionScoreTest extends \TestCase
{

    public $questionAssign;
    public $student;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new QuestionScore;
        $this->questionAssign = QuestionAssignment::all()->random();
        $this->student = Student::all()->random();
        $this->score = QuestionScore::all()->random();
    }

    public function testScopeStudent()
    {
        $s = $this->score->toArray();
        $result = $this->object->onStudent($s['student_id']);
        $this->assertNotEmpty($result);
    }

    public function testScopeQuestionAssignment()
    {
//        return $query->whereQuestionAssignmentId($questionAssignmentId);
    }


    #--------------------------------- getters and setters
    /**
     * Get the score
     * @return float
     */
    public function getScore()
    {
        $expect = $this->score->score;
        $this->assertEquals($expect, $this->score->getScore());
    }


    public function setScore()
    {
        $test = 4.56;
        $this->object->setScore($test);
        $this->assertEquals($test, $this->object->score);
    }

    #---------------------------------------- foreign keys

    public function testExam()
    {
        foreach($this->score->exam as $r)
        {
            $this->assertInstanceOf('App\Exam', $r);
        }
    }


//    public function testUser()
//    {
//        $this->assertInstanceOf('App\User', $this->score->user);
//    }

    public function testQuestionAssignment()
    {
        $this->assertInstanceOf('App\QuestionAssignment', $this->score->questionAssignment);
    }


    public function testQuestion()
    {
        foreach($this->score->question as $r)
        {
            $this->assertInstanceOf('App\Question', $r);
        }
    }

    public function testStudent()
    {
        foreach($this->score->student as $r)
        {
            $this->assertInstanceOf('App\Student', $r);
        }
    }
}