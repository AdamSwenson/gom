<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/30/15
 * Time: 4:55 PM
 */

namespace App;



class ExamTest extends \TestCase
{

    public $exam;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Exam;
        $this->exam = Exam::all()->random();

        \Auth::loginUsingId(self::$userid);
    }


    public function testScopeOnClasses()
    {

//        return $query->where('kumi_id = ?', $kumiId);
    }

    public function testScopeUnlocked()
    {
        $exams = Exam::unlocked()->get();
        foreach ($exams as $e)
        {
            $this->assertInstanceOf('App\Exam', $e);
            $this->assertEquals(0, $e->locked);
        }
    }


    public function testScopeUnreleased()
    {
        $exams = Exam::unreleased()->get();
        foreach ($exams as $e)
        {
            $this->assertInstanceOf('App\Exam', $e);
            $this->assertEquals(0, $e->released);
        }
    }

    public function testScopeReleased()
    {
        $exams = Exam::released()->get();
        foreach ($exams as $e)
        {
            $this->assertInstanceOf('App\Exam', $e);
            $this->assertEquals(1, $e->released);
        }
    }

#----------------------------------------------------------- Setters and getters


    public function testSetTerm()
    {
        $test = $this->faker->text();
        $this->object->setTerm($test);
        $this->assertEquals($test, $this->object->term);
    }


    public function testSetName()
    {
        $test = $this->faker->text();
        $this->object->setName($test);
        $this->assertEquals($test, $this->object->name);
    }


    public function testSetYear()
    {
        $test = $this->faker->year();
        $this->object->setYear($test);
        $this->assertEquals($test, $this->object->year);
    }


    public function testSetLocked()
    {
        $this->object->setLocked(1);
        $this->assertEquals(1, $this->object->locked);
    }

    public function testSetReleased()
    {
        $this->object->setReleased(1);
        $this->assertEquals(1, $this->object->released);
    }


    #------------------------------------------------------ foreign keys


    public function testClasses()
    {
        foreach ($this->exam->classes as $r)
        {
            $this->assertInstanceOf('App\Kumi', $r);
        }
    }


    public function testElements()
    {
        foreach ($this->exam->elements as $r)
        {
            $this->assertInstanceOf('App\Element', $r);
        }
    }


    public function testElementAssignments()
    {
        foreach ($this->exam->elementAssignments as $r)
        {
            $this->assertInstanceOf('App\Element', $r);
        }
    }


//    public function testElementScores()
//    {
//        foreach ($this->exam->elementScores as $r)
//        {
//            $this->assertInstanceOf('App\ElementScore', $r);
//        }
//    }


    public function questions()
    {
        foreach ($this->exam->questions as $r)
        {
            $this->assertInstanceOf('App\Question', $r);
        }
    }

    public function testQuestionAssignments()
    {
        foreach ($this->exam->questionAssignments as $r)
        {
            $this->assertInstanceOf('App\Question', $r);
            $this->assertTrue(is_integer($r->pivot->question_number));
        }
    }


    public function testQuestionScores()
    {
        foreach ($this->exam->questionScores as $r)
        {
            $this->assertInstanceOf('App\QuestionScore', $r);
        }

    }

    public function testUser()
    {
        $this->assertInstanceOf('App\User', $this->exam->user);
    }

    # --------------------------------- Other getters and setters

    public function testGetTerm()
    {
        $this->assertNotEmpty($this->exam->getTerm());
    }

    public function testGetName()
    {
        $result = $this->exam->getName();
        $this->assertTrue(is_string($result));
        $this->assertTrue(count($result) >= 1);
    }


    public function testGetLocked()
    {
        $this->assertTrue(is_integer($this->exam->getLocked()));
    }

    public function testGetReleased()
    {
        $this->assertTrue(is_integer($this->exam->getReleased()));
    }

    /** @test */
    public function isReleasedForReleased(){
        //prep
        $exam = factory(Exam::class)->make(['released' => 1]);
        $exam->released = 1;
        //check
        $this->assertTrue($exam->released, "attribute is correctly set");
        $this->assertTrue($exam->isReleased(), "Exam released is true");
    }

    /** @test */
    public function isReleasedForNotReleased(){
        //prep
        $exam = factory(Exam::class)->make(['released' => 0]);
        //check
        $this->assertFalse($exam->isReleased(), "Exam released is false");
    }
}
