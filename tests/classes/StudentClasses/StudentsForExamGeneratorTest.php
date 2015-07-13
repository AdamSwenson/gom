<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/5/15
 * Time: 5:05 PM
 */

namespace StudentClasses;


class StudentsForExamGeneratorTest extends \PHPUnit_Framework_TestCase {

    protected $object; 
    
    protected function setUp()
    {
        parent::setUp();
    }

    public function testInvoke()
    {
        $students = array();
        $exam = \ExamQuery::create()->filterById(1)->findOneOrCreate();
        $sg = new StudentsForExamGenerator();
        foreach($sg($exam) as $s){
            array_push($students, $s);
            $this->assertInstanceOf('\Student', $s);
        }
    }

}
