<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 10:03 AM
 */

namespace App\classes\ExamClasses\service;


class ExamCreatorTest extends \PHPUnit_Framework_TestCase
{

    public $object;
    public $restrictordao;
    public $examdao;
    public $response_handler;

    function setUp()
    {
        $this->object = new ExamCreator();
        $this->examdao = new \App\classes\ExamClasses\dao\IExamDAOMock();
        $this->restrictordao = new \App\classes\RestrictorClasses\dao\IRestrictorDAOMock();
        $this->response_handler = new \App\classes\JsonOutputClasses\controllers\IResponseChooserMock();
    }

    public function testSet_response_handler()
    {
        $this->object->set_response_handler($this->response_handler);
        $this->assertAttributeInstanceOf('\App\classes\JsonOutputClasses\controllers\IResponseChooser', 'response_handler', $this->object);
    }

    public function testLoad_restrictor_dao()
    {
        $this->object->load_restrictor_dao($this->restrictordao);
        $this->assertAttributeInstanceOf('\App\classes\RestrictorClasses\dao\IRestrictorDAO', 'restrictor_dao', $this->object);
    }

    public function testLoad_exam_dao()
    {
        $this->object->load_exam_dao($this->examdao);
        $this->assertAttributeInstanceOf('\App\classes\ExamClasses\dao\IExamDAO', 'exam_dao', $this->object);
    }

    public function test_create_exam()
    {
        $test = array('year' => '2019', 'term' => 'spring', 'examTopic' => 'testTopic2');
        $this->object->load_restrictor_dao($this->restrictordao);
        $this->object->load_exam_dao($this->examdao);
        $this->object->set_response_handler($this->response_handler);

        $this->object->create_exam($test);

        $this->assertEquals('load_year', $this->restrictordao->called_list[0][0]);
        $this->assertEquals('load_term', $this->restrictordao->called_list[1][0]);
        $this->assertEquals('load_topic', $this->restrictordao->called_list[2][0]);

        $this->assertEquals('save_new_exam', $this->examdao->called_list[0][0]);
        $this->assertInstanceOf('Year', $this->examdao->year);
        $this->assertInstanceOf('Term', $this->examdao->term);
        $this->assertInstanceOf('Topic', $this->examdao->topic);
    }

    public function test_create_exam_count_is_zero()
    {
        $test = array('year' => '2019', 'term' => 'spring', 'examTopic' => 'testTopic2');
        $this->object->load_restrictor_dao($this->restrictordao);
        $this->examdao->set_response(FALSE);
        $this->object->load_exam_dao($this->examdao);
        $this->object->set_response_handler($this->response_handler);
        $this->assertFalse($this->object->create_exam($test));
    }
}
