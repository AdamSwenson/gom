<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/7/17
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Item;

use App\Item;
use App\ItemComment;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Class CommentControllerTest
 * @group controllers
 * @group setup
 * @group item
 * @package App\Http\Controllers\Item
 */
class CommentControllerTest extends \TestCase
{
    use WithoutMiddleware;

    protected $object;
    protected $exam;
    protected $route = 'comments';

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        \Mockery::close();
    }
//
//    /** @test */
//    public function rr(){
//        $i = \factory(Item::class)->create();
//    }

    /** @test */
    public function store()
    {
        /*
         * Sample incoming
         * {"text":"","maxScore":100,"depth":0,"serialNumber":5,"id":3,"comments":[["stock",{"text":"ff","maxScore":100,"depth":0,"type":"comment","valence":"stock"}],["absent",{"text":"","maxScore":100,"depth":0,"type":"comment","valence":"absent"}],["poor",{"text":"","maxScore":100,"depth":0,"type":"comment","valence":"poor"}],["good",{"text":"","maxScore":100,"depth":0,"type":"comment","valence":"good"}],["excellent",{"text":"","maxScore":100,"depth":0,"type":"comment","valence":"excellent"}]],"kind":"item","publicity":false,"examId":-1,"name":"dsss","requestVersion":1}
         */

        $testComments = []; //stands in for the comments array in the incoming item
        foreach ( ItemComment::$valenceTexts as $valence ) {
            $testComments[] = [$valence, ["text" => Factory::create()->sentence, "valence" => $valence]];
        }
        $item = factory(Item::class)->create();

        $data = [
            'item' => $item,
            'itemId' => $item->id,
            'comments' => $testComments
        ];

        //call
        $response = $this->post($this->route . '/' . $item->id, $data);

        //check
        $response->assertStatus(200);

        foreach ( $testComments as $t ) {
            $valence = $t[0];
//            $valence = ItemComment::numericValenceFromText($t[0]);

            $comment = $t[1];
            $this->assertDatabaseHas('item_comments', [
                'item_id' => $item->id,
                'valence' => $valence,
                'body' => $comment['text']
            ]);
        }

    }
}