<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/4/15
 * Time: 3:41 PM
 */

namespace App\classes\ImportExportClasses\Backup;


class BackupMakerTest extends \PHPUnit_Framework_TestCase {

    protected $object; 
    
    protected function setUp()
    {
        parent::setUp();
        $this->object = new BackupMaker;
        $this->exam = \ExamQuery::create()->filterById(1)->findOneOrCreate();

        $score_loader = new \App\classes\ScoreClasses\ScoreLoader();
        $score_loader->set_element_score_handler(new \App\classes\ScoreClasses\ElementScoreHandler());
        $score_loader->set_question_score_handler(new \App\classes\ScoreClasses\QuestionScoreHandler());
        $this->object->setScoreLoader($score_loader);
    }


    public function testLoadRecords()
    {
        $this->object->set_exam($this->exam);
        $this->object->loadRecords();
        $this->assertTrue(count($this->object->records) > 0);
    }
}
