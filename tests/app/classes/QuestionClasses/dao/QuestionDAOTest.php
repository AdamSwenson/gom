<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 11:51 AM
 */

namespace App\classes\QuestionClasses\dao;


class QuestionDAOTest extends \PHPUnit_Framework_TestCase
{
    public $object;

    public function setUp()
    {
        $this->object = new QuestionDAO();
    }


    public function testGet_question_from_array_no_id_no_name()
    {
        $test = array('questionText' => 'sample question text');
        $result = $this->object->get_question_from_array($test);
        $this->assertInstanceOf('\Question', $result);
        $this->assertEquals($test['questionText'], $result->getQuestiontext());
    }

    public function testGet_question_from_array_no_name()
    {
        $test = array('questionID' => 1, 'questionText' => 'sample question text');
        $result = $this->object->get_question_from_array($test);
        $this->assertInstanceOf('\Question', $result);
        $this->assertEquals($test['questionID'], $result->getId());
        $this->assertEquals($test['questionText'], $result->getQuestiontext());
    }

    public function testGet_question_from_array_id_and_name()
    {
        $test = array('questionID' => 3, 'questionText' => 'sample question text', 'questionName' => 'nameQuestion');

        $result = $this->object->get_question_from_array($test);
        $this->assertInstanceOf('\Question', $result);
        $this->assertEquals($test['questionID'], $result->getId());
        $this->assertEquals($test['questionText'], $result->getQuestiontext());
        $this->assertEquals($test['questionName'], $result->getQuestionname());
    }
}
