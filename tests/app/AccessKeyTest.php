<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/7/16
 * Time: 3:28 PM
 */

namespace App;


use Carbon\Carbon;

class AccessKeyTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = factory(AccessKey::class)->create();
    }

    /** @test */
    public function getKey()
    {
        #prep
        $expect = $this->object->access_key;

        #call
        $result = $this->object->getKey();

        #check
        $this->assertEquals($expect, $result, "returns expected value");
    }

    /** @test */
    public function setKey()
    {

        $key = "22taco";
        $this->object->setKey($key);

        #check
        $this->assertEquals($key, $this->object->access_key);
    }

    /** @test */
    public function getExamId()
    {
        #prep
        $expect = $this->object->exam_id;

        #call
        $result = $this->object->getExamId();

        #check
        $this->assertEquals($expect, $result, "returns expected value");
    }

    /** @test */
    public function setExamId()
    {
        $examId = 22;
        $this->object->setExamId($examId);

        #check
        $this->assertEquals($examId, $this->object->exam_id);
    }

    /** @test */
    public function getStudentId()
    {
        #prep
        $expect = $this->object->student_id;

        #call
        $result = $this->object->getStudentId();

        #check
        $this->assertEquals($expect, $result, "returns expected value");
    }

    /** @test */
    public function setStudentId()
    {
        $studentId = 22;
        $this->object->setStudentId($studentId);

        #check
        $this->assertEquals($studentId, $this->object->student_id);
    }

    /**
     * Returns the date the student's access to feedback expires
     * @test
     */
    public function getExpirationDate()
    {
        #prep
        $expect = $this->object->access_expires;

        #call
        $result = $this->object->getExpirationDate();

        #check
        $this->assertEquals($expect, $result, "returns expected value");
    }

    /**
     * Updates the date on which access will expire.
     * Saves to database. Do not need to call update independently.
     * @test
     */
    public function setExpirationDate()
    {
        #prep
        $ex = "1/22/16";
        $id = $this->object->id;

        #call
        $this->object->setExpirationDate($ex);

        #check
        $obj = AccessKey::find($id);
        $this->assertEquals(Carbon::parse($ex), Carbon::parse($obj->access_expires));
    }

    /**
     * @test
     */
    public function getEmailSent()
    {
        #prep
        $expect = $this->object->email_sent;

        #call
        $result = $this->object->getEmailSent();

        #check
        $this->assertEquals($expect, $result, "returns expected value");
    }

    /**
     * Updates the database to indicate that the student has been sent an email with
     * feedback / link to feedback.
     * @test
     */
    public function markEmailSent()
    {
        #prep
        $id = $this->object->id;

        #call
        $this->object->markEmailSent();

        #check
        $obj = AccessKey::find($id);
        $this->assertEquals(1, $obj->email_sent, "returns expected value");

    }


    #------------------------------------------ queries
    /**
     * @test
     */
    public function scopeOnExam()
    {
        #prep
        $examId = $this->object->exam_id;

        #call
        $result = AccessKey::onExam($examId);

        #check
        $this->assertTrue(count($result) > 0, "returns expected value");

    }

    #------------------------------------------ foreign keys
    /** @test */
    public function exam()
    {
        #prep
        $expect = $this->object->exam_id;

        #call
        $result = $this->object->exam;

        #check
        $this->assertInstanceOf(Exam::class, $result, "returns an exam1");
        $this->assertEquals($expect, $result->id, "has expected id");
    }

    /** @test */
    public function student()
    {
        #prep
        $expect = $this->object->student_id;

        #call
        $result = $this->object->student;

        #check
        $this->assertInstanceOf(Student::class, $result, "returns a student");
        $this->assertEquals($expect, $result->id, "has expected id");

    }
}
