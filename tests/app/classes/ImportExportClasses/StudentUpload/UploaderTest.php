<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 11:11 AM
 */

namespace App\classes\ImportExportClasses\StudentUpload;


class UploaderTest extends \TestCase
{

    static public $valid_files = array("tests/test_student_upload_valid.csv");
    static public $invalid_files = array("tests/test_student_upload_invalid.csv");

    public $exam;
    public $student_name;
    public $kumi_name;
    public $sid;
    public $email;
    protected $object;
    protected $file_processor;
    protected $request;
    protected $students;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Uploader;
        $yr = \YearQuery::create()->filterByContent(2015)->findOneOrCreate();
        $tm = \TermQuery::create()->filterByContent('testterm')->findOneOrCreate();
        $tc = \TopicQuery::create()->filterByContent('testtopic')->findOneOrCreate();
        $this->exam = new \Exam();
        $this->exam->setTopic($tc);
        $this->exam->setTerm($tm);
        $this->exam->setYear($yr);
        $this->exam->save();

        $this->student_name = MD5(microtime());
        $this->kumi_name = MD5(microtime());
        $this->sid = mt_rand(1000000, 9999999);
        $this->email = $this->sid . '@fake.com';

        $this->request = new \App\classes\RequestClasses\IFileRequestMock();
        array_push($this->request->filenames, 'fakefilename.csv');

        $this->file_processor = new \App\classes\ImportExportClasses\StudentUpload\IStudentCsvProcessorMock();

        $this->students = array(
            array(
                'student_id' => 999997,
                'student_name' => 'testname',
                'class_nickname' => 'classname1',
                'emails' => 'fake@fake.com'
            ),
            array(
                'student_id' => 999998,
                'student_name' => 'testname2',
                'class_nickname' => 'classname1',
                'emails' => 'fake2@fake.com'
            ),
            array(
                'student_id' => 999996,
                'student_name' => 'testname3',
                'class_nickname' => 'classname3',
                'emails' => 'fake3@fake.com'
            ),
        );
        $this->file_processor->students = $this->students;
    }

    /**
     * @covers \App\classes\ImportExportClasses\StudentUpload\Uploader::set_exam
     */
    public function testSet_exam()
    {
        $this->object->set_exam($this->exam);
        $this->assertAttributeInstanceOf('Exam', 'exam', $this->object);
    }

    public function testSet_file_processor()
    {
        $this->object->set_file_processor($this->file_processor);
        $this->assertAttributeInstanceOf('\App\classes\ImportExportClasses\StudentUpload\IStudentCsvProcessor', 'processor',
            $this->object);
    }

    /**
     * @covers \App\classes\ImportExportClasses\StudentUpload\Uploader::process
     * @covers \App\classes\ImportExportClasses\StudentUpload\Uploader::load_students
     * @covers \App\classes\ImportExportClasses\StudentUpload\Uploader::record_students
     */
    public function testProcess()
    {
        $this->file_processor->set_response(true);
        $this->object->set_exam($this->exam);
        $this->object->set_file_processor($this->file_processor);
        $this->object->process($this->request);

        foreach ($this->students as $s) {
            echo $s['student_id'];
            $students = \StudentQuery::create()->filterBySid($s['student_id'])->find();
            foreach ($students as $student) {
                $this->assertInstanceOf('\Student', $student);
                $this->assertEquals($s['student_id'], $student->getSid());
                $this->assertEquals($s['student_name'], $student->getStudentname());
                $this->assertEquals($s['emails'], $student->getEmail());

                $class = \KumiQuery::create()->filterByNickname($s['class_nickname'])->findOne();
                $this->assertEquals($s['class_nickname'], $class->getNickname());

                $ca = \ExamClassAssignmentQuery::create()->filterByKumi($class)->filterByExam($this->exam)->findOne();
                $this->assertInstanceOf('\ExamClassAssignment', $ca);
            }
        }
    }

//
//    public function testProcess_throws_on_()
//    {}

        /**
     * @covers \App\classes\ImportExportClasses\StudentUpload\Uploader::add_record
     */
    public function testAdd_record()
    {
        $this->object->set_exam($this->exam);
        $this->object->add_record($this->sid, $this->student_name, $this->kumi_name, $this->email);

        $db_student = \StudentQuery::create()->filterBySid($this->sid)->findOne();
        $this->assertEquals($this->sid, $db_student->getSid());
        $this->assertEquals($this->student_name, $db_student->getStudentname());
        $this->assertEquals($this->email, $db_student->getEmail());


        $db_kumi = \KumiQuery::create()->filterByNickname($this->kumi_name)->findOne();
        $this->assertEquals($this->exam->getExamyear(), $db_kumi->getYear());

        $db_assign = \StudentClassAssignmentQuery::create()->filterByStudentid($db_student->getId())->find();

        $assigned_classes = array();
        foreach ($db_assign as $assign) {
            $k = $assign->getKumi();
            array_push($assigned_classes, $k->getId());
        }
        $this->assertContains($db_kumi->getId(), $assigned_classes);
    }

}
