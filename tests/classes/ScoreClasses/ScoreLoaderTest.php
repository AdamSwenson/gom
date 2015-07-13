<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 4:57 PM
 */

namespace ScoreClasses;


class ScoreLoaderTest extends \PHPUnit_Framework_TestCase {
    public $object;
    public $question_score_handler;
    public $element_score_handler;

    protected function setUp()
    {
        $this->object = new \ScoreClasses\ScoreLoader();
        $this->question_score_handler = new \ScoreClasses\IQuestionScoreHandlerMock();
        $this->element_score_handler = new \ScoreClasses\IElementScoreHandlerMock();
        parent::setUp();
    }

    /**
     * TODO: Fix loader so can call getElementscore() on the mock element score loader
     * @covers \ScoreClasses\ScoreLoader::load
     */
//    public function testLoad()
//    {
//        $exam = \ExamQuery::create()->filterById(1)->findOneOrCreate();
//        $question = \QuestionQuery::create()->filterById(1)->findOneOrCreate();
//        $student = \StudentQuery::create()->filterById(1)->findOneOrCreate();
//        $this->object->set_question_score_handler($this->question_score_handler);
//        $this->object->set_element_score_handler($this->element_score_handler);
//        $result = $this->object->load($exam, $question, $student);
//        var_dump($result);
//    }

    /**
     * @covers \ScoreClasses\ScoreLoader::set_question_score_handler
     */
    public function testSet_question_score_handler()
    {
        $this->object->set_question_score_handler($this->question_score_handler);
        $this->assertAttributeInstanceOf('\ScoreClasses\IQuestionScoreHandler', 'question_score_handler', $this->object);
    }

    /**
     * @covers \ScoreClasses\ScoreLoader::set_element_score_handler
     */
    public function testSet_element_score_handler()
    {
        $this->object->set_element_score_handler($this->element_score_handler);
        $this->assertAttributeInstanceOf('\ScoreClasses\IElementScoreHandler', 'element_score_handler', $this->object);
    }



}
