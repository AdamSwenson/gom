<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 5:04 PM
 */

namespace CommentClasses\dao;


class AssignmentFactoryTest extends \PHPUnit_Framework_TestCase {
    public $object;


    protected function setUp()
    {
        parent::setUp();
        $this->object = new AssignmentFactory();
    }

    public function testSet_exam()
    {
        $this->object->set_exam(new \Exam());
        $this->assertAttributeInstanceOf('\Exam', 'exam', $this->object);
    }

    public function testSet_element()
    {
        $this->object->set_element(new \Element());
        $this->assertAttributeInstanceOf('\Element', 'element', $this->object);
    }

    public function testLoad_poor()
    {
//        $this->object->set_exam(new \Exam());
//        $this->object->set_element(new \Element());
//        $result = $this->object->load('poor');
//        $this->assertInstanceOf('\CommentPoor', $result);
    }



}
