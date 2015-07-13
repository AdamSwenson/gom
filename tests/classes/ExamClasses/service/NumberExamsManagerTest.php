<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 10:15 AM
 */

namespace classes\ExamClasses\service;


use ExamClasses\service\NumberExamsManager;

class NumberExamsManagerTest extends \PHPUnit_Framework_TestCase {
    public $cleaner;
    public $object;



    protected function setUp()
    {
        parent::setUp();
        $this->object = new NumberExamsManager();
        $this->cleaner = new \SecurityClasses\cleaning\ICleanerFactoryMock();
        $this->response_handler = new \JsonOutputClasses\controllers\IResponseChooserMock();
    }

    protected function tearDown(){
        unset($_SESSION);
    }

    public function testSet_response_handler()
    {
        $this->object->set_response_handler($this->response_handler);
        $this->assertAttributeInstanceOf('\JsonOutputClasses\controllers\IResponseChooser', 'response_handler', $this->object);
    }

    public function testLoad_cleaner()
    {
        $this->object->load_cleaner($this->cleaner);
        $this->assertAttributeInstanceOf('\SecurityClasses\cleaning\ICleanerFactory', 'cleaner', $this->object);
    }

    public function testGet_number_exams()
    {
        $numexams = 35;
        $_SESSION[NumberExamsManager::KEY] = $numexams;
        $this->assertEquals($numexams, $this->object->get_number_exams());
    }

    public function testSet_number_exams()
    {
        $this->object->set_response_handler($this->response_handler);
        $numexams = 30;
        $this->cleaner->set_response($numexams);
        $this->object->load_cleaner($this->cleaner);
        $this->assertTrue($this->object->set_number_exams($numexams));
        $this->assertNotEmpty($_SESSION['totalExams']);
        $this->assertEquals($numexams, $_SESSION['totalExams']);
    }

    /**
     * @expectedException \Exception
     */
    public function testSet_number_exams_throws_on_too_large_number()
    {
        $this->object->set_response_handler($this->response_handler);
        $numexams = NumberExamsManager::MAX_EXAMS + 1;
        $this->cleaner->set_response($numexams);
        $this->object->load_cleaner($this->cleaner);
        $this->object->set_number_exams($numexams);
     }

    /**
     * @expectedException \Exception
     */
    public function testSet_number_exams_throws_when_cleaner_returns_false()
    {
        $this->object->set_response_handler($this->response_handler);
        $this->cleaner->set_response(FALSE);
        $this->object->load_cleaner($this->cleaner);
        $this->object->set_number_exams(34);
    }



}
