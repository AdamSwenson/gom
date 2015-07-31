<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 10:48 AM
 */

namespace App;


class KumiTest extends \TestCase
{

    public $kumi;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Kumi;
        $this->kumi = Kumi::all()->random();
    }

    public function testSetName()
    {
        $test = $this->faker->text();
        $this->object->setName($test);
        $this->assertEquals($test, $this->object->nickname);
    }

    public function testSetYear()
    {
        $test = $this->faker->year();
        $this->object->setYear($test);
        $this->assertEquals($test, $this->object->year);
    }

#--------- Foreign keys

    public function testStudents()
    {
        foreach ($this->kumi->students as $r)
        {
            $this->assertInstanceOf('App\Student', $r);
        }
    }

    public function testExams()
    {
        foreach ($this->kumi->exams as $r)
        {
            $this->assertInstanceOf('App\Exam', $r);
        }
    }

    public function testUser()
    {
        $this->assertInstanceOf('App\User', $this->kumi->user);
    }

}
