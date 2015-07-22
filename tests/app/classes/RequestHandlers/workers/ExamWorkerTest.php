<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/21/15
 * Time: 2:22 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\RequestHandlers\dao\IExamDAOMock;
use App\Exam;
use App\Kumi;

class ExamWorkerTest extends \TestCase
{

    public $dao;
    protected $object;

    public function setUp()
    {

        parent::setUp();
        $this->object = new ExamWorker;
        $this->dao = new IExamDAOMock();
        $this->dao->set_response(new Exam());
        $this->object->dao = $this->dao;
    }

//    public function testCloneExamination()
//    {
//    }


    public function testGetExam()
    {
        $examId = $this->faker->randomNumber(3);
        $this->object->getExam($examId);
        $this->assertEquals('load_exam', $this->dao->called);
        $this->assertEquals($examId, $this->dao->calledList[0][1][0]);
    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testGetExamExceptionBadId()
//    {
//        $examId = 'catfish';
//        $this->object->getExam($examId);
//    }

//    /**
//     * @expectedException \Exception
//     */
//    public function testGetExamExceptionNoExam()
//    {
//        $examId = 1000000245552222222;
//        $this->object->getExam($examId);
//    }


    public function testGetAllExams()
    {
        $this->object->getAllExams();
        $this->assertEquals('load_all_exams', $this->dao->called);
    }

    public function testGetAllExamsWithClassId()
    {
        $classId = 43;
        $this->object->getAllExams(43);
        $this->assertEquals('load_exams_by_class', $this->dao->called);
        $this->assertEquals($classId, $this->dao->calledList[0][1][0]);
    }

    public function testCreateExam()
    {
        $examName = $this->faker->text();
        $term = $this->faker->word();
        $year = $this->faker->year();
        $classId = 4;

        $this->object->createExam($examName, $year, $term, $classId);

        $this->assertEquals('save_new_exam', $this->dao->called);
        $this->assertEquals([$year, $term, $examName], $this->dao->calledList[0][1]);
    }

    public function testDeleteExam()
    {
        $examId = $this->faker->randomNumber(3);
        $this->object->deleteExam($examId);
        $this->assertEquals('delete_exam', $this->dao->called);
        $this->assertEquals($examId, $this->dao->calledList[0][1][0]);
    }


    public function testReleaseExam()
    {
        $examId = $this->faker->randomNumber(3);
        $this->object->releaseExam($examId);

        $this->assertEquals('mark_exam_released', $this->dao->called);
        $this->assertEquals($examId, $this->dao->calledList[0][1][0]);
    }


    public function testUnreleaseExam()
    {
        $examId = $this->faker->randomNumber(3);
        $this->object->unreleaseExam($examId);

        $this->assertEquals('unmark_exam_released', $this->dao->called);
        $this->assertEquals($examId, $this->dao->calledList[0][1][0]);
    }

    public function testLockExam()
    {
        $examId = $this->faker->randomNumber(3);
        $this->object->lockExam($examId);

        $this->assertEquals('lock_exam', $this->dao->called);
        $this->assertEquals($examId, $this->dao->calledList[0][1][0]);
    }

    public function  testUnlockExam()
    {
        $examId = $this->faker->randomNumber(3);
        $this->object->unlockExam($examId);

        $this->assertEquals('unlock_exam', $this->dao->called);
        $this->assertEquals($examId, $this->dao->calledList[0][1][0]);
    }

}