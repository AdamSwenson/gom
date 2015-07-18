<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/17/15
 * Time: 3:37 PM
 */

namespace App\classes\ImportExportClasses\dao;


use Faker\Factory;

class ImportDaoTest extends \TestCase
{
    public $user;
    public $exam;
    public $student_name;
    public $kumi_name;
    public $sid;
    public $email;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ImportDao;
        $this->exam = \ExamQuery::create()
            ->filterByUser($this->user)
            ->findOne();

        $this->student_name = Factory::create()->name();
        $this->kumi_name = Factory::create()->word();
        $this->sid = Factory::create()->numberBetween(1000000, 9999999);
        $this->email = Factory::create()->email();
    }

    public function testSetExam()
    {
        $this->object->setExam($this->exam);
        $this->assertAttributeEquals($this->exam, 'exam', $this->object);
    }


    public function testAdd_record()
    {
        $this->object->setExam($this->exam);
        $this->object->add_record($this->sid, $this->student_name, $this->kumi_name, $this->email);

        $db_student = \StudentQuery::create()
            ->filterByUser()
            ->filterBySid($this->sid)
            ->findOne();
        $this->assertEquals($this->sid, $db_student->getSid());
        $this->assertEquals($this->student_name, $db_student->getStudentname());
        $this->assertEquals($this->email, $db_student->getEmail());

        $db_kumi = \KumiQuery::create()
            ->filterByNickname($this->kumi_name)
            ->findOne();
        $this->assertEquals($this->exam->getExamyear(), $db_kumi->getYear());

        $db_assign = \StudentClassAssignmentQuery::create()
            ->filterByStudentid($db_student->getId())
            ->find();

        $assigned_classes = array();
        foreach ($db_assign as $assign) {
            $k = $assign->getKumi();
            array_push($assigned_classes, $k->getId());
        }
        $this->assertContains($db_kumi->getId(), $assigned_classes);
    }

}
