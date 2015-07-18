<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/4/15
 * Time: 3:41 PM
 */

namespace App\classes\ImportExportClasses\Backup;


use App\classes\ScoreClasses\ElementScoreHandler;
use App\classes\ScoreClasses\QuestionScoreHandler;
use App\classes\ScoreClasses\ScoreLoader;

class BackupMakerTest extends \TestCase {

    protected $object; 
    
    public function setUp()
    {
        parent::setUp();
        $this->object = new BackupMaker;
        $this->exam = \ExamQuery::create()->filterById(1)->findOneOrCreate();

        $score_loader = new ScoreLoader();
        $score_loader->set_element_score_handler(new ElementScoreHandler());
        $score_loader->set_question_score_handler(new QuestionScoreHandler());
        $this->object->setScoreLoader($score_loader);
    }


    /**
     * @group slowTests
     */
    public function testLoadRecords()
    {
        $this->object->set_exam($this->exam);
        $this->object->loadRecords();
        $this->assertTrue(count($this->object->records) > 0);
    }
}
