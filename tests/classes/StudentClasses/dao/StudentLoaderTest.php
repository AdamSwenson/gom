<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:47 PM
 */

namespace StudentClasses\dao;


class StudentLoaderTest extends \PHPUnit_Framework_TestCase {

    protected $object;
    protected $exam;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new StudentLoader;
        $ecaq = \ExamClassAssignmentQuery::create()->find();
        $this->exam = $ecaq[0]->getExam();

    }

    /**
     * @covers \StudentClasses\dao\StudentLoader::load_students_by_exam
     */
    public function testLoad_students_by_exam()
    {
        $this->object->load_students_by_exam($this->exam);
        $this->assertTrue(count($this->object->students) > 0);
        foreach ($this->object->students as $s) {
            $this->assertInstanceOf('\Student', $s);
        }
    }

}
