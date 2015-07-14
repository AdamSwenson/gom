<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 7:25 AM
 */

namespace App\classes\OutputClasses\facades;


class VisitorTest extends \PHPUnit_Framework_TestCase
{

    protected $object;
    protected $exam;
    protected $student;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new Visitor;
        $this->student = new \Student();
        $this->exam = new \Exam();
    }

    public function testMake()
    {
        $r = Visitor::make($this->exam, $this->student);
        $this->assertInstanceOf('\OutputClasses\facades\Visitor', $r);
        $this->assertAttributeInstanceOf('\Student', 'student', $r);
        $this->assertAttributeInstanceOf('\Exam', 'exam', $r);
    }
}
