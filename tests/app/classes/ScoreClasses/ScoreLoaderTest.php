<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 4:57 PM
 */

namespace App\classes\ScoreClasses;


class ScoreLoaderTest extends \TestCase {
    public $object;
    public $question_score_handler;
    public $element_score_handler;

    public function setUp()
    {
        $this->object = new \App\classes\ScoreClasses\ScoreLoader();
        $this->question_score_handler = new \App\classes\ScoreClasses\IQuestionScoreHandlerMock();
        $this->element_score_handler = new \App\classes\ScoreClasses\IElementScoreHandlerMock();
        parent::setUp();
    }

    /**
     * TODO: Fix loader so can call getElementscore() on the mock element score loader
     * @covers \App\classes\ScoreClasses\ScoreLoader::load
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
     * @covers \App\classes\ScoreClasses\ScoreLoader::set_question_score_handler
     */
    public function testSet_question_score_handler()
    {
        $this->object->set_question_score_handler($this->question_score_handler);
        $this->assertAttributeInstanceOf('\App\classes\ScoreClasses\IQuestionScoreHandler', 'question_score_handler', $this->object);
    }

    /**
     * @covers \App\classes\ScoreClasses\ScoreLoader::set_element_score_handler
     */
    public function testSet_element_score_handler()
    {
        $this->object->set_element_score_handler($this->element_score_handler);
        $this->assertAttributeInstanceOf('\App\classes\ScoreClasses\IElementScoreHandler', 'element_score_handler', $this->object);
    }



}
