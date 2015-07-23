<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 11:38 AM
 */

namespace App\classes\OutputClasses\service;


use App\classes\ScoreClasses\dao\IScoreDAOMock;

class CommentKludgeTest extends \TestCase {

    protected $object; 
    
    public function setUp()
    {

        parent::setUp();
        $this->object = new CommentKludge;
        $this->dao = new IScoreDAOMock();
        $this->object->setDao($this->dao);
    }

    public function testFind_stock()
    {
        $test =array(
            array('score' => 0.0, 'expect' => CommentKludge::FORGOT),
            array('score' => 0.1, 'expect' => CommentKludge::FORGOT),
            array('score' => 0.5, 'expect' => CommentKludge::FORGOT),
            array('score' => 0.6, 'expect' => CommentKludge::POOR),
            array('score' => 1.0, 'expect' => CommentKludge::POOR),
            array('score' => 2.0, 'expect' => CommentKludge::POOR),
            array('score' => 2.1, 'expect' => CommentKludge::OKAY),
            array('score' => 4.3, 'expect' => CommentKludge::OKAY),
            array('score' => 5.5, 'expect' => CommentKludge::OKAY),
            array('score' => 5.6, 'expect' => CommentKludge::GOOD),
            array('score' => 6.75, 'expect' => CommentKludge::GOOD),
            array('score' => 7.5, 'expect' => CommentKludge::GOOD),
            array('score' => 7.6, 'expect' => CommentKludge::GREAT),
            array('score' => 9.0, 'expect' => CommentKludge::GREAT),
            array('score' => 10.0, 'expect' => CommentKludge::GREAT),
        );
        foreach($test as $t){
            $this->assertEquals(trim($t['expect']), trim($this->object->find_stock($t['score'])));
        }
    }
    public function testLoad_comments_for_question()
    {
        $num = 3;
        $exams = \ExamQuery::create()->limit($num)->find();
        $students = \StudentQuery::create()->limit($num)->find();
        for($i=0; $i<$num; $i++) {
            $result = $this->object->load_comments_for_question($exams[$i], $students[$i], 1);
            foreach($result as $r) {
                $this->assertInstanceOf('\ElementScore', $r);
                $this->assertInstanceOf('\Element', $r->getElement());
                $this->assertTrue(count($r->getElement()->getCommenttext()) >0);
//                $this->assertTrue($r->getElement()->isModified());
            }
        }
    }



}
