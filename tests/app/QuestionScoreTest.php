<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 11:09 AM
 */

namespace App;

use Faker\Factory;


/**
 * @property mixed score
 */
class QuestionScoreTest extends \TestCase
{

    public $questionAssign;
    public $student;
    public $exam;//populated by setup call
    public $students;//populated by setup call
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new QuestionScore;
//        $fixture1 = $this->makeExamWAssignedQuestions(3);
//        $fixture2 = $this->setupExamWithStudents($fixture1['exam1']);
//        //exam1 and students are now stored in
//        $this->questionAssign = $fixture1['questions'][0] QuestionAssignment::where('exam_id', $fixture1['exam1'])->where('question_id', $fixture1['questions'][0]->id)->first();
//        $this->student = $this->students[0];
//
//        $this->score = new QuestionScore();
//        $this->score->question_assignment_id = $this->questionAssign->id;
//        $this->score->student_id = $this->student->id;
//        $this->score->score = \Faker\Factory::create()->randomFloat(2, 0, 100);
//        $this->score->save();
//
        $this->score = factory(QuestionScore::class)->create();
        $this->questionAssign = QuestionAssignment::find($this->score->question_assignment_id);
        $this->student = Student::find($this->score->student_id);
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


    public function testSetAsCustom()
    {
        //prep
        $this->assertTrue($this->object->is_custom != true);

        //call
        $this->object->setAsCustom();

        //check
        $this->assertEquals(true, $this->object->is_custom);
    }

    public function testIsScoreCustom()
    {
        $this->object->is_custom = 1;
        $this->assertEquals(true, $this->object->isScoreCustom());
    }

    public function testIsScoreCustomWithBoolean()
    {
        $this->object->is_custom = true;
        $this->assertEquals(true, $this->object->isScoreCustom());
    }

    public function testIsScoreCustomWhereFalse()
    {
        $this->object->is_custom = false;
        $this->assertEquals(false, $this->object->isScoreCustom());
    }
}