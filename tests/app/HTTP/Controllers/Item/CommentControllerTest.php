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
            $comment = $t[1];
            $this->assertDatabaseHas('item_comments', [
                'item_id' => $item->id,
                'valence' => $valence,
                'body' => $comment['text']
            ]);
        }

    }
}