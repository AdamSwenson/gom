<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 1:38 PM
 */

namespace App\classes\CommentClasses\service;


use App\classes\CommentClasses\dao\IAssignmentFactoryMock;
use App\classes\SecurityClasses\cleaning\ICleanerFactoryMock;

class AssignmentProcessorTest extends \TestCase
{
    public $object;
    public $cleaner;
    public $factory;
    public $exam;
    public $element;

    public function setUp()
    {
        parent::setUp();
        $this->object = new AssignmentProcessor();
        $this->cleaner = new ICleanerFactoryMock();
        $this->factory = new IAssignmentFactoryMock();
        $this->exam = new \Exam();
        $this->element = new \Element();
    }

    public function testLoad_cleaner()
    {
        $this->object->load_cleaner($this->cleaner);
        $this->assertAttributeInstanceOf('\App\classes\SecurityClasses\cleaning\ICleanerFactory', 'cleaner', $this->object);
    }


    public function testLoad_factory()
    {
        $this->object->load_factory($this->factory);
        $this->assertAttributeInstanceOf('\App\classes\CommentClasses\dao\IAssignmentFactory', 'factory', $this->object);
    }

    public function testProcess_stock_text()
    {
    }

    public function testProcess_element_assignment()
    {
    }

    public function testProcess_score_assignment()
    {

//    $incoming = array('test');
//        $this->object->load_factory($this->factory);
//        //This handles score assignment
//        $this->factory->set_exam($exam);
//        $element = \ElementsQuery::create()->filterById()->findOneOrCreate();
//        $this->factory->set_element($element);
//        $this->process_missing($incoming);
//        $this->process_poor($incoming);
//        $this->process_competent($incoming);
//        $this->process_excellent($incoming);

//        $properties = ['questionNumber',
//        'subtask',
//        'missing_min' => array('type' => 'missing'),
//        'missing_max',
//        'poor_min',
//        'poor_max',
//        'competent_min',
//        'competent_max',
//        'excellent_min',
//        'excellent_max'];
    }
//
//
//    public function testProcess_missing()
//    {
//        $cm = \CommentMissingQuery::create()->filterByExam($this->exam)->filterByElement($this->element)->findOneOrCreate();
//        $incoming = array('missing_min' => '0', 'missing_max' => '0.25');
//        $this->factory->set_response($cm);
//        $this->object->load_factory($this->factory);
//        $this->object->load_cleaner(new \App\classes\SecurityClasses\cleaning\CleanerFactory());
//        $result = $this->object->process_missing($incoming);
//        $this->assertInstanceOf('\CommentMissing', $result);
//        $this->assertEquals('load', $this->factory->called);
//        $this->assertEquals('missing', $this->factory->called_list[1][0]);
//    }
//
//    public function testProcess_poor()
//    {
//        $cm = \CommentPoorQuery::create()->filterByExam($this->exam)->filterByElement($this->element)->findOneOrCreate();
//        $incoming = array('poor_min' => '1', 'poor_max' => '3.25');
//        $this->factory->set_response($cm);
//        $this->object->load_factory($this->factory);
//        $this->object->load_cleaner(new \App\classes\SecurityClasses\cleaning\CleanerFactory());
//        $result = $this->object->process_poor($incoming);
//        $this->assertInstanceOf('\CommentPoor', $result);
//        $this->assertEquals('load', $this->factory->called);
//        $this->assertEquals('poor', $this->factory->called_list[1][0]);
//    }
//
//    public function testProcess_competent()
//    {
//        $cm = \CommentCompetentQuery::create()->filterByExam($this->exam)->filterByElement($this->element)->findOneOrCreate();
//        $incoming = array('competent_min' => '4', 'competent_max' => '6');
//        $this->factory->set_response($cm);
//        $this->object->load_factory($this->factory);
//        $this->object->load_cleaner(new \App\classes\SecurityClasses\cleaning\CleanerFactory());
//        $result = $this->object->process_poor($incoming);
//        $this->assertInstanceOf('\CommentCompetent', $result);
//        $this->assertEquals('load', $this->factory->called);
//        $this->assertEquals('competent', $this->factory->called_list[1][0]);
//    }
//
//    public function testProcess_excellent()
//    {
//        $cm = \CommentExcellentQuery::create()->filterByExam($this->exam)->filterByElement($this->element)->findOneOrCreate();
//        $incoming = array('excellent_min' => '4', 'excellent_max' => '6');
//        $this->factory->set_response($cm);
//        $this->object->load_factory($this->factory);
//        $this->object->load_cleaner(new \App\classes\SecurityClasses\cleaning\CleanerFactory());
//        $result = $this->object->process_poor($incoming);
//        $this->assertInstanceOf('\CommentExcellent', $result);
//        $this->assertEquals('load', $this->factory->called);
//        $this->assertEquals('excellent', $this->factory->called_list[1][0]);
//
//    }
}
