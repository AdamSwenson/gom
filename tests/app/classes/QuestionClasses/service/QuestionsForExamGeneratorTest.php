<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/5/15
 * Time: 5:29 PM
 */

namespace App\classes\QuestionClasses\service;


class QuestionsForExamGeneratorTest extends \PHPUnit_Framework_TestCase {

    protected $object; 
    
    protected function setUp()
    {
        parent::setUp();

    }

    public function testInvoke()
    {
        $exam = \ExamQuery::create()->filterById(1)->findOneOrCreate();
        $qf = new QuestionsForExamGenerator();
        foreach($qf($exam) as $q){
            $this->assertInstanceOf('\Question', $q);
        }
    }

}
