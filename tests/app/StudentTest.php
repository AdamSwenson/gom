<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 10:42 AM
 */

namespace App;


class StudentTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Student;
        $this->student = Student::all()->random();
    }

    public function testSetEmail()
    {
        $test = $this->faker->email();
        $this->object->setEmail($test);
        $this->assertEquals($test, $this->object->email);
    }

#-------- foreign keys


    public function testsKumis()
    {
        foreach($this->student->kumis as $r)
        {
            $this->assertInstanceOf('App\Kumi', $r);
        }
    }

    public function testExams()
    {
        foreach($this->student->exams as $r)
        {
            $this->assertInstanceOf('App\Exam', $r);
        }
    }

    public function testUser()
    {
        $this->assertInstanceOf('App\User', $this->student->user);
    }
}
