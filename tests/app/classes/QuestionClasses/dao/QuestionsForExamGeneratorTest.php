<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/5/15
 * Time: 5:29 PM
 */

namespace App\classes\QuestionClasses\dao;


class QuestionsForExamGeneratorTest extends \TestCase {

    protected $object; 
    
    public function setUp()
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
