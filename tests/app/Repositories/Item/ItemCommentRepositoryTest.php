<?php


namespace App\Repositories\Item;


use App\Comment;

class ItemCommentRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ItemCommentRepository;
    }

    public function testGetCommentForValence()
    {

    }

    public function testGetCommentForScore()
    {

    }

    public function testMakeCutoffsFromMaxScore()
    {
        $score = 100;
        $expect = [0, 34, 67, 100];

        //call
        $result = $this->object->makeCutoffsFromMaxScore($score);

        //check
        $i=0;
        foreach($result as $k => $v){
            $this->assertEquals($expect[$i], $v);
            $this->assertEquals(Comment::$valences[$i], $k);
            $i++;
        }
    }

    public function testChooseValenceByScore()
    {
        foreach ( ItemCommentRepository::$assignmentCriteria as $k => $v ) {
            $score = $v['maxScore'] - 1;

            //call
            $result = $this->object->chooseValenceByScore($score);

            //check
            $this->assertEquals($k, $result);
        }


    }

}
