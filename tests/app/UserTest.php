<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/6/16
 * Time: 1:03 PM
 */

namespace App;


use Illuminate\Support\Facades\Auth;

class UserTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = User::find(self::$userid);
    }


    /**
     * @test
     */
    public function getAllExams()
    {
        #prep
        factory(Exam::class)->create();

        #call
        $result = $this->object->getAllExams();

        foreach ( $result as $r )
        {
            $this->assertInstanceOf(Exam::class, $r, "expected object type returned");
            $this->assertEquals(self::$userid, $r->user_id, "object has correct user id");
        }

    }

    /**
     * @test
     */
    public function getAllElements()
    {
        #prep
        factory(ElementAssignment::class)->create();

        #call
        $result = $this->object->getAllElements();

        foreach ( $result as $r )
        {
            $this->assertInstanceOf(Element::class, $r, "expected object type returned");
            $this->assertEquals(self::$userid, $r->user_id, "object has correct user id");
        }

    }


    /**
     * @test
     */
    public function getAllElementAssignments()
    {
        #prep
        factory(ElementAssignment::class)->create();

        #call
        $result = $this->object->getAllElementAssignments();

        foreach ( $result as $r )
        {
            $this->assertInstanceOf(ElementAssignment::class, $r, "expected object type returned");
            $this->assertEquals(self::$userid, $r->user_id, "object has correct user id");
        }

    }


    /**
     * @test
     */
    public function getAllElementScores()
    { #prep
        factory(ElementScore::class)->create();

        #call
        $result = $this->object->getAllElementScores();

        foreach ( $result as $r )
        {
            $this->assertInstanceOf(ElementScore::class, $r, "expected object type returned");
            $this->assertEquals(self::$userid, $r->user_id, "object has correct user id");
        }
    }

    /**
     * @test
     */
    public function getAllQuestions()
    {
        #prep
        factory(Question::class)->create();

        #call
        $result = $this->object->getAllQuestions();

        foreach ( $result as $r )
        {
            $this->assertInstanceOf(Question::class, $r, "expected object type returned");
            $this->assertEquals(self::$userid, $r->user_id, "object has correct user id");
        }
    }

    /**
     * @test
     */
    public function getAllQuestionAssignments()
    {
        #prep
        factory(QuestionAssignment::class)->create();

        #call
        $result = $this->object->getAllQuestionAssignments();

        foreach ( $result as $r )
        {
            $this->assertInstanceOf(QuestionAssignment::class, $r, "expected object type returned");
            $this->assertEquals(self::$userid, $r->user_id, "object has correct user id");
        }
    }

    /**
     * @test
     */
    public function getAllQuestionScores()
    { #prep
        factory(QuestionScore::class)->create();

        #call
        $result = $this->object->getAllQuestionScores();

        foreach ( $result as $r )
        {
            $this->assertInstanceOf(QuestionScore::class, $r, "expected object type returned");
            $this->assertEquals(self::$userid, $r->user_id, "object has correct user id");
        }
    }

    /**
     * @test
     */
    public function getAllStudents()
    { #prep
        $this->setupExamWithStudents();

        #call
        $result = $this->object->getAllStudents();

        foreach ( $result as $r )
        {
            $this->assertInstanceOf(Student::class, $r, "expected object type returned");
            $this->assertEquals(self::$userid, $r->user_id, "object has correct user id");
        }

    }

    /**
     * @test
     */
    public function ownsWhereTrue()
    {
        #prep
        $exam = factory(Exam::class)->create();

        #call
        $this->assertTrue($this->object->owns($exam), "returns true as expected");
    }

    /**
     * @test
     */
    public function ownsWhereFalse()
    {
        #prep
        Auth::logInUsingId(2);
        $exam = factory(Exam::class)->create();
        Auth::logInUsingId(self::$userid);

        #call
        $this->assertFalse($this->object->owns($exam), "returns false as expected");
    }

}
