<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 1:06 PM
 */

namespace App\classes\ElementClasses\dao;


class ElementAssignmentDAOTest extends \PHPUnit_Framework_TestCase {
    public $object;
    public $question;
    public $exam;
    public $element;

    protected function setUp()
    {

        $this->object = new ElementAssignmentDAO();

        $this->exam = \classes\DbTestAids::make_exam('testterm4', 2012, 'testtopic4');
        $this->question = \classes\DbTestAids::make_question('testquestiontext');
        $this->element = \classes\DbTestAids::make_element('testelement name');

        parent::setUp();
    }

    public function testRecord()
    {
        $result = $this->object->record($this->exam, $this->question, $this->element, 4);
        $this->assertInstanceOf('\ElementAssignment', $result);
    }

    public function testLoad_elements()
    {
        $result = $this->object->load_elements($this->exam, $this->question);
        if(count($result) > 0){
            $this->assertInstanceOf('\Element', $result[0]);
        }
    }

//    public function testLoad_by_exam()
//    {
//        $exams = \ExamQuery::create()->limit(3)->find();
//        foreach($exams as $ex){
//            $result = $this->object->load_by_exam($ex);
//            foreach($result as $r){
//     //           $q = $r->getQuestion();
//
//                $this->assertInstanceOf('\ElementAssignment', $r);
//                $this->assertInstanceOf('\Question', $r->getQuestion());
//                $this->assertInstanceOf('\Element', $r->getElement());
//        //        $this->assertInstanceOf('\QuestionAssigner', $r->getQuestionassigner());
//            }
//        }
//$e = new \Question();
//        $e->getQuestionAssigners();
//    }

}
