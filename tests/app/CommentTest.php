<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 3:43 PM
 */

namespace App;


class CommentTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Comment;
        $this->comment = Comment::all()->random(1);
    }

    public function tearDown()
    {
    }

    public function testGetBody()
    {
        $text = $this->faker->text();
        $this->object->body = $text;
        $this->assertEquals($text, $this->object->getBody());
    }

    public function testGetValence()
    {
        foreach(Comment::$valences as $v)
        {
            $this->object->valence = $v;
            $this->assertEquals($v, $this->object->getValence());
        }
    }

    public function testSetValence()
    {
        foreach(Comment::$valences as $v)
        {
            $this->object->setValence($v);
            $this->assertEquals($v, $this->object->valence);
        }
    }


    #---------------------------------------- queries
    public function testScopeOnValence()
    {
        $valence = $this->faker->randomElement(Comment::$valences);
        $comments = Comment::onValence($valence)->get();
        foreach ($comments as $c)
        {
            $this->assertEquals($valence, $c->valence);
        }
    }

//    public function testScopeOnElement()
//    {
//        $e = $this->comment->element;
//        $eid = $e[0]->id;
//        $comments = Comment::onElement($eid);
//        $this->assertNotEmpty($comments);
//        foreach($comments as $c)
//        {
//            $this->assertEquals($eid, $c->element->id);
//        }
//    }


#----------------- foreign keys

    public function testUser()
    {
        $this->assertInstanceOf('App\User', $this->comment->user);
    }


    public function testElement()
    {
        $this->assertInstanceOf('App\Element', $this->comment->element);
    }
}
