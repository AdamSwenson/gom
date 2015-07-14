<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 2:53 PM
 */

namespace App\classes\ExamClasses\service;


class ExamServiceParentTest extends \PHPUnit_Framework_TestCase {

    protected $object;
    public $examdao;
    public $response_handler;
    public $cleaner;

    protected function setUp()
    {
        parent::setUp();
        $this->object = $this->getMockForAbstractClass('\App\classes\ExamClasses\service\ExamServiceParent');
        $this->examdao = new \App\classes\ExamClasses\dao\IExamDAOMock();
        $this->cleaner = new \App\classes\SecurityClasses\cleaning\ICleanerFactoryMock();
        $this->response_handler = new \App\classes\JsonOutputClasses\controllers\IResponseChooserMock();
    }


    /**
     * @covers \App\classes\ExamClasses\service\ExamServiceParent::set_response_handler
     */
    public function testSet_response_handler()
    {
        $this->object->set_response_handler($this->response_handler);
        $this->assertAttributeInstanceOf('\App\classes\JsonOutputClasses\controllers\IResponseChooser', 'response_handler', $this->object);
    }

    /**
     * @covers \App\classes\ExamClasses\service\ExamServiceParent::load_exam_dao
     */
    public function testLoad_exam_dao()
    {
        $this->object->load_exam_dao($this->examdao);
        $this->assertAttributeInstanceOf('\App\classes\ExamClasses\dao\IExamDAO', 'exam_dao', $this->object);
    }

    /**
     * @covers \App\classes\ExamClasses\service\ExamServiceParent::load_cleaner
     */
    public function testLoad_cleaner()
    {
        $this->object->load_cleaner($this->cleaner);
        $this->assertAttributeInstanceOf('\App\classes\SecurityClasses\cleaning\ICleanerFactory', 'cleaner', $this->object);
    }
}
