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
        //$this->exam1 = Exam::all()->random();

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
        $this->assertTrue(!is_null($e), "found something");
        $this->assertInstanceOf(Exam::class, $e, "found an exam1");
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
        $this->assertTrue(!is_null($e), "found something");
        $this->assertInstanceOf(Exam::class, $e, "found an exam1");
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
        $qs = factory(QuestionScore::class)->create();
        $qa = QuestionAssignment::find($qs->question_assignment_id);
        $exam1 = Exam::find($qa->exam_id);
        $this->assertEquals(true, $exam1->isGraded(), "is in fact graded");

        $exam2 = factory(Exam::class)->create();
        $this->assertEquals(false, $exam2->isGraded(), "is not in fact graded");
    }

    /**
     * @test
     */
    public function wasPreviouslyReleasedWhereTrue()
    {
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
    public function wasPreviouslyReleasedWhereFalse()
    {
        #prep
        $exam = factory(Exam::class)->create(['previously_released' => false]);
        $this->assertTrue($exam->released == false, "Starts released");
        $this->assertTrue($exam->previously_released == false, "Starts not previously released");

        #call and check
        $this->assertFalse($exam->wasPreviouslyReleased(), "returns false");
    }

    /**
     * @test
     */
    public function isGradableGivesTrueWithQuestionsAndStudents()
    {
        #prep
        $fixture = $this->setupExamWithStudents();
        $exam = $fixture['exam1'];
        $this->makeQuestionAssignment($exam, factory(Question::class)->create(), 2);

        #call and test
        $this->assertEquals(true, $exam->isGradable());
    }

    /**
     * @test
     */
    public function isGradableGivesFalseWithNoQuestions()
    {
        $exam = factory(Exam::class)->create();

        $this->assertEquals(false, $exam->isGradable());
    }

    /**
     * @test
     */
    public function isGradableGivesFalseWithNoStudents()
    {
        #prep
        $exam = Exam::find($this->examWithQuestionsButNoStudentsId);
        $this->assertInstanceOf(Exam::class, $exam, "exam1 object to test");
        $this->assertEquals(0, count($exam->getAllAssociatedStudents()), "exam1 has no students");

        #call
        $result = $exam->isGradable();

        #check
        $this->assertEquals(false, $result, "returns false");

    }


    /* ----------------- Queries --------------- */

    /**
     */
    public function testScopeOnClasses()
    {

//        return $query->where('kumi_id = ?', $kumiId);
    }

    public function testScopeUnlocked()
    {
        $exams = Exam::unlocked()->get();
        foreach ( $exams as $e ) {
            $this->assertInstanceOf('App\Exam', $e);
            $this->assertEquals(0, $e->locked);
        }
    }


    public function testScopeUnreleased()
    {
        $exams = Exam::unreleased()->get();
        foreach ( $exams as $e ) {
            $this->assertInstanceOf('App\Exam', $e);
            $this->assertEquals(0, $e->released);
        }
    }

    public function testScopeReleased()
    {
        $exams = Exam::released()->get();
        foreach ( $exams as $e ) {
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
        foreach ( $exam->classes as $c ) {
            foreach ( $c->students as $s ) {
                $students[] = $s;
            }
        }
        $this->assertTrue(count($students) > 0, "At least one student associated with exam1");

        #call
        $associatedStudents = $exam->getAllAssociatedStudents();

        #check
        $this->assertTrue(count($associatedStudents) > 0, "At least one student associated with exam1");
        foreach ( $associatedStudents as $as ) {
            $this->assertContains($as, $students, "returned student in the array of expected students");
        }

    }

#----------------------------------------------------------- Item ordering

    /** @test */
    public function initializeAssignmentRoot()
    {
        $exam = factory(Exam::class)->create();

        //call
        $exam->initializeAssignmentRoot();

        //check
        $this->assertDatabaseHas('assignments', ['exam_id' => $exam->id, 'item_id' => $exam->id, 'parent_id' => null]);

        //make sure only one record
        $this->assertEquals(1, Assignment::where('exam_id', $exam->id)->get()->count());

    }


    /** @test */
    public function initializeAssignmentRootWhenAlreadySet()
    {
        //prep
        $exam = factory(Exam::class)->create();
        $exam->initializeAssignmentRoot();
        //check setup
        $this->assertDatabaseHas('assignments',
            ['exam_id' => $exam->id,
                'item_id' => $exam->id,
                'parent_id' => null
            ]);


        //call again
        $result = $exam->initializeAssignmentRoot();

        //check
        $this->assertEquals(true, $result, "returned true without fuss");
        //make sure only one record
        $this->assertEquals(1, Assignment::where('exam_id', $exam->id)->get()->count(), "still only one item ");
    }


    /** @test */
    public function getAssignmentsRoot()
    {
        $exam = factory(Exam::class)->create();
        //prep
        $expected = Assignment::create(['exam_id' => $exam->id,
            'parent_id' => null,
            'item_id' => $exam->id,
            'position' => 0]);


        //call
        $result = $exam->getAssignmentsRoot();

        //check
        $this->assertTrue(!empty($result));
        $this->assertInstanceOf(Assignment::class, $result);

        $this->assertEquals($exam->id, $result->exam_id, "has correct exam1 id set");
        $this->assertEquals(null, $result->parent_id, "parent id is null as expected");
        $this->assertEquals(0, $result->position, "at 0th position as expected");
        $this->assertEquals($exam->id, $result->item_id, "exam1 id used in item id field");

    }

    /** @test */
    public function resetAssignments()
    {
        //prep by creating assignments for an exam1
        $exam = factory(Exam::class)->create();
        $exam->initializeAssignmentRoot();
        //check setup
        $this->assertDatabaseHas('assignments',
            ['exam_id' => $exam->id,
                'item_id' => $exam->id,
                'parent_id' => null
            ]);
        //grab the id of the assignment row
        $oldAssignmentId = Assignment::where('exam_id', $exam->id)
            ->where('item_id', $exam->id)
            ->where('parent_id', null)
            ->first()
            ->id;

        //call
        $exam->resetAssignments();

        //check
        $this->assertDatabaseHas('assignments',
            ['exam_id' => $exam->id,
                'item_id' => $exam->id,
                'parent_id' => null
            ]);
        $newAssignmentId = Assignment::where('exam_id', $exam->id)
            ->where('item_id', $exam->id)
            ->where('parent_id', null)
            ->first()
            ->id;
        $this->assertNotEquals($newAssignmentId, $oldAssignmentId);
    }


    #------------------------------------------------------ foreign keys


    public function testClasses()
    {
        foreach ( $this->exam->classes as $r ) {
            $this->assertInstanceOf('App\Kumi', $r);
        }
    }


    public function testElements()
    {
        $fixture = $this->makeElementAssignmentsForQuestion(3);
        $elements = $fixture['exam1']->elements;
        $this->assertTrue(!is_null($elements), "Returned something");
        $this->assertTrue(count($elements) > 0, "At least one thing returned");
        foreach ( $elements as $r ) {
            $this->assertInstanceOf('App\Element', $r, "Object returned is element model");
        }
    }


    public function testElementAssignments()
    {
        $fixture = $this->makeElementAssignmentsForQuestion(3);
        $exam = $fixture['exam1'];
        $elements = $exam->elements;
        $elementAssignments = $exam->elementAssignments;
        $this->assertTrue(!is_null($elementAssignments), "Returned something");
        $this->assertTrue(count($elementAssignments) > 0, "At least one thing returned");
        foreach ( $elementAssignments as $r ) {
            $this->assertInstanceOf('App\Element', $r, "Returned element object");
            $this->assertTrue(is_numeric($r->pivot->subtask), "Returned object has subtask");
        }
    }


//    public function testElementScores()
//    {
//        foreach ($this->exam1->elementScores as $r)
//        {
//            $this->assertInstanceOf('App\ElementScore', $r);
//        }
//    }


    public function testQuestions()
    {
        #prep
        $numQuestions = 5;

        $r = $this->makeExamWAssignedQuestions($numQuestions);
        $exam = $r['exam1'];
        $questionIds = $r['questionIds'];

        #call
        $questions = $exam->questionAssignments;
        $this->assertTrue(!is_null($questions), "Returned something");
        $this->assertTrue(count($questions) > 0, "At least one question returned");
        $this->assertEquals(count($questionIds), count($questions), "Correct number of questions returned");
        foreach ( $exam->questions as $q ) {
            $this->assertInstanceOf('App\Question', $q, "Object returned was a question model");
            $qid = $q->id; //easier to see in debug
            $this->assertTrue(in_array($qid, $questionIds), "Question in the expected list");
        }
    }

    public function testQuestionAssignments()
    {
        $this->assertTrue(!is_null($this->exam->questionAssignments));

        foreach ( $this->exam->questionAssignments as $r ) {
            $this->assertInstanceOf('App\Question', $r, "question object returned");
            $this->assertTrue(is_integer($r->pivot->question_number));
        }
    }


    public function testQuestionScores()
    {
        foreach ( $this->exam->questionScores as $r ) {
            $this->assertInstanceOf('App\QuestionScore', $r);
        }

    }

//    public function testStudents()
//    {
//        $students = $this->exam1->students();
//        $this->assertTrue(! is_null($students), "Returned something");
//        $this->assertTrue(count($students) >0, "At least one thing returned");
//        foreach ($this->exam1->students as $r)
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


    public function testGetUserId()
    {
        $this->assertEquals(self::$userid, $this->exam->getUserId(), "returns user id");
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
