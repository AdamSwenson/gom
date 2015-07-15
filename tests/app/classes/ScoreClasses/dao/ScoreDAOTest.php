<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/6/15
 * Time: 10:35 AM
 */

namespace App\classes\ScoreClasses\dao;


class ScoreDAOTest extends \TestCase {

    public $worker;
    protected $object;

    static $expected_load_objects = array(
        array('request' => 'element', 'expected' => '\App\classes\ScoreClasses\dao\ElementLoader'),
        array('request' => 'question', 'expected' => '\App\classes\ScoreClasses\dao\QuestionLoader'));

    public function setUp()
    {
        parent::setUp();
        $this->object = new ScoreDAO;
        $this->worker = new ILoaderMock();
    }

    public function testLoad_worker_no_student()
    {
        foreach(self::$expected_load_objects as $r)
        {
            $this->object->setExam(new \Exam());
            $this->object->load_worker($r['request']);
            $this->assertAttributeInstanceOf($r['expected'], 'worker', $this->object);
            $this->assertAttributeInstanceOf('\Exam', 'exam', $this->object->worker);
            $this->assertAttributeEmpty('student', $this->object->worker);
        }
    }

    public function testLoad_worker_with_student()
    {
        foreach(self::$expected_load_objects as $r)
        {
            $this->object->setExam(new \Exam());
            $this->object->setStudent(new \Student());
            $this->object->load_worker($r['request']);
            $this->assertAttributeInstanceOf($r['expected'], 'worker', $this->object);
            $this->assertAttributeInstanceOf('\Exam', 'exam', $this->object->worker);
            $this->assertAttributeInstanceOf('\Student', 'student', $this->object->worker);
        }
    }

    public function testLoad_worker_with_no_exam()
    {
        foreach(self::$expected_load_objects as $r)
        {
            $this->object->load_worker($r['request']);
            $this->assertAttributeEmpty('student', $this->object->worker);
            $this->assertAttributeEmpty('exam', $this->object->worker);
        }
    }

    /**
     * @expectedException \Exception
     */
    public function testLoad_worker_invalid_kind()
    {
        $bad = array('cat', 45, '', array(), true, false);
        foreach($bad as $b) {
            $this->object->load_worker($b);
        }
    }

    public function testElement_scores_by_question_number()
    {
        $num = 3;
        $exams = \ExamQuery::create()->limit($num)->find();
        $students = \StudentQuery::create()->limit($num)->find();

        for($i=0; $i<$num; $i++){
            $result = $this->object->element_scores_by_question_number($exams[$i], $students[$i], 1);
            foreach($result as $r){
                $this->assertInstanceOf('\ElementScore', $r);
                $this->assertInstanceOf('\Element', $r->getElement());
                $this->assertTrue($r->getElementscore() >= 0, "score got loaded");
                $this->assertTrue(count($r->getElement()->getCommenttext()) >0);
            }
        }
    }


    public function testIs_string_request()
    {
        $qnum = 45;
        $testing = array(
            array('input' => 'all', 'input_arg' => '', 'expected' => 'all', 'expected_arg' => array()),
            array('input' => 'questionnumber', 'input_arg' => $qnum, 'expected' => 'question_number', 'expected_arg' => array($qnum)),
        );
        $this->object->worker = $this->worker;
        foreach($testing as $t){
            $result = $this->object->is_string_request($t['input'], $t['input_arg']);
            $this->assertTrue($result);
            $this->assertEquals($t['expected'], $this->worker->called);
            $this->assertEquals($t['expected_arg'], $this->worker->arguments);
        }
    }

    public function testIs_string_request_on_invalid_by()
    {
//
//        $bad = array('cat', 45, array('cat'), true);
//        foreach($bad as $b){
//            $this->assertFalse($this->object->is_string_request($b, true));
//        }
    }

    /**
     * @expectedException \Exception
     */
    public function testIs_string_request_excepts_on_empty_by()
    {
        $bad = array('', false);
        foreach($bad as $b){
            $this->assertFalse($this->object->is_string_request($b));
        }
    }


    public function testIs_object_request()
    {
        $this->object->worker = $this->worker;
        $testing = array(
            array('input' => new \Question(), 'expected' => true),
            array('input' => new \Element(), 'expected' => true),
            array('input' => new \Student(), 'expected' => false));
        foreach($testing as $t){
            $this->assertEquals($this->object->is_object_request($t['input']), $t['expected']);
        }
    }

    public function testIs_id_request_question()
    {
        $this->worker->type = 'question';
        $this->object->worker = $this->worker;
        $result = $this->object->is_id_request(1);
        $this->assertTrue($result);
        $this->assertEquals('object', $this->worker->called);
        $this->assertInstanceOf('\Question', $this->worker->arguments[0]);
    }

    public function testIs_id_request_element()
    {
        $this->worker->type = 'element';
        $this->object->worker = $this->worker;
        $result = $this->object->is_id_request(1);
        $this->assertTrue($result);
        $this->assertEquals('object', $this->worker->called);
        $this->assertInstanceOf('\Element', $this->worker->arguments[0]);
    }

    public function testIs_id_request_non_int_id()
    {
        $badids = array('cat', '3', 3.0, '', true);
        foreach($badids as $b){
            $this->worker->type = 'element';
            $this->object->worker = $this->worker;
            $this->assertFalse($this->object->is_id_request($b));
        }
    }
//
//        if(is_integer($by))
//        {
//            switch($this->worker->type)
//            {
//                case 'question':
//                    $item = \QuestionQuery::create()->filterById($by)->findOne();
//                    break;
//
//                case 'element':
//                    $item = \ElementQuery::create()->filterById($by)->findOne();
//                    break;
//                default:
//                    throw new \Exception();
//            }
//            $this->check_set($item);
//            $this->results = $this->worker->object($item);
//            return true;
//        }else{
//            return false;
//        }
//    }
}
