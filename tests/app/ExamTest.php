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

    public $examWithQuestionsAndStudentsId = 1;
    public $examWithQuestionsButNoStudentsId = 6;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Exam;
        $this->exam = Exam::find($this->examWithQuestionsAndStudentsId);
        //$this->exam = Exam::all()->random();

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

    /**
     * @test
     */
    public function isGradableGivesTrueWithQuestionsAndStudents(){
        #prep
        $exam = Exam::find(1);

        #call and test
        $this->assertEquals(true, $exam->isGradable());
    }

    /**
     * @test
     */
    public function isGradableGivesFalseWithNoQuestions(){
        $exam = factory(Exam::class)->create();

        $this->assertEquals(false, $exam->isGradable());
    }

    /**
     * @test
     */
    public function isGradableGivesFalseWithNoStudents(){
        #prep
        $exam = Exam::find($this->examWithQuestionsButNoStudentsId);
        $this->assertInstanceOf(Exam::class, $exam, "exam object to test");
        $this->assertEquals(0, count($exam->getAllAssociatedStudents()), "exam has no students");

        #call
        $result = $exam->isGradable();

        #check
        $this->assertEquals(false, $result, "returns false");

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
        $elements = $this->exam->elements;
        $this->assertTrue(! is_null($elements), "Returned something");
        $this->assertTrue(count($elements) >0, "At least one thing returned");
        foreach ($elements as $r)
        {
            $this->assertInstanceOf('App\Element', $r, "Object returned is element model");
        }
    }


    public function testElementAssignments()
    {
        $elementAssignments = $this->exam->elementAssignments;
        $this->assertTrue(! is_null($elementAssignments), "Returned something");
        $this->assertTrue(count($elementAssignments) >0, "At least one thing returned");
        foreach ($elementAssignments as $r)
        {
            $this->assertInstanceOf('App\Element', $r, "Returned element object");
            $this->assertTrue(is_numeric($r->pivot->subtask), "Returned object has subtask");
        }
    }


//    public function testElementScores()
//    {
//        foreach ($this->exam->elementScores as $r)
//        {
//            $this->assertInstanceOf('App\ElementScore', $r);
//        }
//    }


    public function testQuestions()
    {
        $questions = $this->exam->questions;
        $this->assertTrue(! is_null($questions), "Returned something");
        $this->assertTrue(count($questions) >0, "At least one question returned");
        foreach ($questions as $r)
        {
            $this->assertInstanceOf('App\Question', $r, "Object returned was a question model");
        }
    }

    public function testQuestionAssignments()
    {
        $this->assertTrue(! is_null($this->exam->questionAssignments));

        foreach ($this->exam->questionAssignments as $r)
        {
            $this->assertInstanceOf('App\Question', $r, "question object returned");
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

//    public function testStudents()
//    {
//        $students = $this->exam->students();
//        $this->assertTrue(! is_null($students), "Returned something");
//        $this->assertTrue(count($students) >0, "At least one thing returned");
//        foreach ($this->exam->students as $r)
//        {
//            $this->assertInstanceOf(Student::class, $r, "student object returned");
//        }
//    }



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

    
    public function testGetUserId(){
        $this->assertEquals(self::$userid, $this->exam->getUserId(), "returns user id" );
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
