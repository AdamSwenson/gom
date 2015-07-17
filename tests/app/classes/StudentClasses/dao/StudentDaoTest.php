<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:47 PM
 */

namespace App\classes\StudentClasses\dao;


class StudentDaoTest extends \TestCase {

    protected $object;
    protected $exam;

    public function setUp()
    {
        parent::setUp();
        $this->object = new StudentDao;
        $ecaq = \ExamClassAssignmentQuery::create()->find();
        $this->exam = $ecaq[0]->getExam();
    }

    /**
     * @covers \App\classes\StudentClasses\dao\StudentLoader::load_students_by_exam
     */
    public function testLoad_students_by_exam()
    {
        $results = $this->object->load_students_by_exam($this->exam);
        $this->assertTrue(count($results) > 0);
        foreach ($results as $s) {
            $this->assertInstanceOf('\Student', $s);
        }
    }

}
