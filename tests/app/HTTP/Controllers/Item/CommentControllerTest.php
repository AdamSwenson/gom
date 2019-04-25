<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/7/17
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Item;

use App\Exam;
use App\Http\Requests\Item\ItemCommentRequest;
use App\Item;
use App\ItemComment;
use App\Models\NewGom\ItemScore;
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
        $this->object = new CommentController();
    }

    public function tearDown()
    {
        \Mockery::close();
    }


    /** @test */
    public function store_testedDirectly()
    {
        $testComments = []; //stands in for the comments array in the incoming item
        foreach ( ItemComment::$valenceTexts as $valence ) {
            $testComments[] = [$valence, ["text" => Factory::create()->sentence, "valence" => $valence]];
        }
        $item = factory(Item::class)->create();
        $item->save();

        $data = new ItemCommentRequest();
        $data['item'] = $item;
        $data['itemId'] = $item->id;
        $data['comments'] = $testComments;

        //call
        $this->object->store($item, $data);

        //check
        $comments = $item->comments;
        $comments =  collect($comments);
        foreach ( $testComments as $t ) {
            $valence = $t[0];
            $testText = $t[1]['text'];
            $c = $comments->where('valence', '==', $valence)->first();

            $this->assertEquals($c->body, $testText, $valence);
        }

    }

    /** @test */
    public function store_testedViaRequest()
    {
        $testComments = []; //stands in for the comments array in the incoming item
        foreach ( ItemComment::$valenceTexts as $valence ) {
            $testComments[] = [$valence, ["text" => Factory::create()->sentence, "valence" => $valence]];
        }
        $item = factory(Item::class)->create();
        $item->save();

        $data = [
            'item' => $item,
            'itemId' => $item->id,
            'comments' => $testComments
        ];

        //call
        $response = $this->post($this->route . '/' . $item->id, $data);

        //check
        $response->assertStatus(200);

        $comments = $item->comments;
        $comments =  collect($comments);
        foreach ( $testComments as $t ) {
            $valence = $t[0];
            $testText = $t[1]['text'];
            $c = $comments->where('valence', '==', $valence)->first();

            $this->assertEquals($c->body, $testText, $valence);
        }

    }

    /** @test */
    public function store_withOverwiteDefaults()
    {
        $testComments = []; //stands in for the comments array in the incoming item
        foreach ( ItemComment::$valenceTexts as $valence ) {
            $testComments[] = [$valence, ["text" => Factory::create()->sentence, "valence" => $valence]];
        }
        $item = factory(Item::class)->create();
        $item->save();

        $exam = \factory(Exam::class)->create();
        //create item scores
        $itemScore = new ItemScore();
        $itemScore->item()->associate($item);
        $itemScore->exam()->associate($exam);

        $data = [
            'item' => $item,
            'itemId' => $item->id,
            'comments' => $testComments,
            'examId' => $exam->id,
            'overwriteDefaults' => true
        ];

        //call
        $response = $this->post($this->route . '/' . $item->id, $data);

        //check
        $response->assertStatus(200);

        $comments = $item->comments;
        $comments =  collect($comments);
        foreach ( $testComments as $t ) {
            $valence = $t[0];
            $testText = $t[1]['text'];
            $c = $comments->where('valence', '==', $valence)->first();

            $this->assertEquals($c->body, $testText, $valence);
        }

    }

    public function handleUpdateDefaults_noChange(){

        //check
        //no comments changed

        //ensure no
    }

    public function handleUpdateDefaults_oneValenceChange(){
//ensure all other valences are intact

        //ensure comments on scores in other exams with the same
        //item have not been affected
    }


    public function handleUpdateDefaults_multiValenceChange(){

    }


}