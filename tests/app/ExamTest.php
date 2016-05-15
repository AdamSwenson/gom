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


    /**
     * @test
     */
    public function releaseExam()
    {
        #prep
        $exam = factory(Exam::class)->create();
        $this->assertTrue($exam->released == false, "Default released");
        $this->assertTrue($exam->previously_released == false, "Default previously released");
        $examId = $exam->id;

        #call
        $exam->releaseExam();

        #check
        $e = Exam::find($examId);
        $this->assertTrue(! is_null($e), "found something");
        $this->assertInstanceOf(Exam::class, $e, "found an exam");
        $this->assertTrue($exam->released == true, "Released set to true in db");
        $this->assertTrue($exam->previously_released == true, "Previously released set to true in db");

    }

    /**
     * @test
     */
    public function hideExam()
    {
        #prep
        $exam = factory(Exam::class)->create(['released' => true, 'previously_released' => true]);
        $exam->released = true;
        $exam->previously_released = true;
        $exam->save();
        $this->assertTrue($exam->released == true, "Starts released");
        $this->assertTrue($exam->previously_released == true, "Starts previously released");
        $examId = $exam->id;

        #call
        $exam->hideExam();

        #check
        $e = Exam::find($examId);
        $this->assertTrue(! is_null($e), "found something");
        $this->assertInstanceOf(Exam::class, $e, "found an exam");
        $this->assertTrue($exam->released == false, "Released set to false in db");
        $this->assertTrue($exam->previously_released == true, "Previously released still set to true in db");
    }

    /**
     * @test
     */
    public function isReleasedWhereNotReleased()
    {
        #prep
        $exam = factory(Exam::class)->create();
        $exam->released = true;
        $exam->previously_released = false;
        $exam->save();
        $examId = $exam->id;
        $exam = Exam::find($examId);

       $this->assertTrue($exam->released === true, "Starts not released");
        $this->assertTrue($exam->previously_released === false, "Starts not previously released");

        #call and check
        $this->assertTrue($exam->isReleased() == true, "returns false");
    }

    /**
     * @test
     */
    public function isReleasedWhereReleased()
    {
        #prep
        $exam = factory(Exam::class)->create(['released' => true, 'previously_released' => true]);
        $exam->released = true;
        $exam->previously_released = true;
        $exam->save();
        $this->assertTrue($exam->released == true, "Starts released");
        $this->assertTrue($exam->previously_released == true, "Starts previously released");

        #call and check
        $this->assertTrue($exam->isReleased() == true, "returns true");
    }



    /**
     * @test
     */
    public function isGraded()
    {
        $exam = Exam::find(1);
        $this->assertEquals(true, $exam->isGraded(), "is in fact graded");

        $exam2 = factory(Exam::class)->create();
        $this->assertEquals(false, $exam2->isGraded(), "is not in fact graded");
    }

    /**
     * @test
     */
    public function wasPreviouslyReleasedWhereTrue(){
        #prep
        $exam = factory(Exam::class)->create(['previously_released' => true]);
        $exam->previously_released = true;
        $exam->save();
        $this->assertTrue($exam->previously_released, "Starts previously released");

        #call and check
        $this->assertTrue($exam->wasPreviouslyReleased(), "returns true");
    }

    /**
     * @test
     */
    public function wasPreviouslyReleasedWhereFalse(){
        #prep
        $exam = factory(Exam::class)->create(['previously_released' => false]);
        $this->assertTrue($exam->released  == false, "Starts released");
        $this->assertTrue($exam->previously_released == false, "Starts not previously released");

        #call and check
        $this->assertFalse($exam->wasPreviouslyReleased(), "returns false");
    }




    /* ----------------- Queries --------------- */

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

    public function testGetAllAssociatedStudents()
    {
        #Prep
        $exam = Exam::find(1);

        //make sure has students
        $this->assertTrue(count($exam->classes) > 0, "At least one associated class");
        $students = [];
        foreach ($exam->classes as $c)
        {
            foreach ($c->students as $s)
            {
                $students[] = $s;
            }
        }
        $this->assertTrue(count($students) > 0, "At least one student associated with exam");

        #call
        $associatedStudents = $exam->getAllAssociatedStudents();

        #check
        $this->assertTrue(count($associatedStudents) > 0, "At least one student associated with exam");
        foreach ($associatedStudents as $as)
        {
            $this->assertContains($as, $students, "returned student in the array of expected students");
        }

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
        $result = $this->exam->getTerm();
        $this->assertTrue(is_string($result));
        $this->assertTrue(count($result) >= 1);
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
    public function isReleasedForReleased()
    {
        //prep
        $exam = factory(Exam::class)->make(['released' => 1]);
        $exam->released = 1;
        //check
        $this->assertTrue($exam->released, "attribute is correctly set");
        $this->assertTrue($exam->isReleased(), "Exam released is true");
    }

    /** @test */
    public function isReleasedForNotReleased()
    {
        //prep
        $exam = factory(Exam::class)->make(['released' => 0]);
        //check
        $this->assertFalse($exam->isReleased(), "Exam released is false");
    }
}
