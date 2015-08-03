<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 2:07 PM
 */

namespace App\Repositories\Element;



use App\Comment;

class CommentRepositoryTest extends \TestCase
{

    public $comment;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new CommentRepository;
        $this->comment = Comment::all()->random();
    }


    public function testGetCommentForValence()
    {
        $eid = $this->comment->element_id;
        $valence = $this->comment->valence;
        $result = $this->object->getCommentForValence($eid, $valence);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\Comment', $result);
        $this->assertEquals($this->comment->id, $result->getId());
    }


    public function testChooseValenceByScore()
    {
        foreach(CommentRepository::$assignmentCriteria as $k => $v)
        {
            $this->assertEquals($k, $this->object->chooseValenceByScore($v['maxScore']));
            $this->assertEquals($k, $this->object->chooseValenceByScore($v['minScore']));
        }
    }

    /**
     * @expectedException \Exception
     */
    public function testChooseValenceByScoreExceptionOutOfMaxRange()
    {
        $this->object->chooseValenceByScore(11);
    }

//    /**
//     * @expectedException \Exception
//     */
//    public function testChooseValenceByScoreExceptionOutOfMinRange()
//    {
//        $this->object->chooseValenceByScore(-1);
//    }
}
