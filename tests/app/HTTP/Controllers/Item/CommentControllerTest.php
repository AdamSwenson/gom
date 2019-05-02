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
        $comments = collect($comments);
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
        $comments = collect($comments);
        foreach ( $testComments as $t ) {
            $valence = $t[0];
            $testText = $t[1]['text'];
            $c = $comments->where('valence', '==', $valence)->first();

            $this->assertEquals($c->body, $testText, $valence);
        }

    }

    /** @test */
    public function store_withOverwriteDefaults()
    {
        $testComments = []; //stands in for the comments array in the incoming item
        foreach ( ItemComment::$valenceTexts as $valence ) {
            $testComments[] = [$valence, ["text" => Factory::create()->sentence, "valence" => $valence]];
        }
        $item = factory(Item::class)->create();
        $exam = \factory(Exam::class)->create();
        //create item scores
        $itemScore = \factory(ItemScore::class)->create(['item_id' => $item,
            'exam_id' => $exam]);

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
        $comments = collect($comments);
        foreach ( $testComments as $t ) {
            $valence = $t[0];
            $testText = $t[1]['text'];
            $c = $comments->where('valence', '==', $valence)->first();

            $this->assertEquals($c->body, $testText, $valence);
        }

    }

    /** @test */
    public function handleUpdateDefaults_noChange()
    {
        $exam = \factory(Exam::class)->create();
        $comment = \factory(ItemComment::class)->create();
        $expected = $comment->body;

        //call
        $this->object->handleUpdateDefaults($exam, $comment, $comment->body);

        //check
        $this->assertEquals($expected, $comment->body, "Comment text not updated");
    }

    /** @test */
    public function handleUpdateDefaults_onlyChangesCommentsOnCurrentExam()
    {
        //ensure comments on scores in other exams with the same
        //item have not been affected
        $item = \factory(Item::class)->create();
        $exam1 = \factory(Exam::class)->create();
        $exam2 = \factory(Exam::class)->create();
        $comment = \factory(ItemComment::class)->create(['item_id' => $item]);
        $newText = $this->faker->paragraph();

        $unchangedScore = \factory(ItemScore::class)->create(['item_id' => $item, 'exam_id' => $exam1, 'comment_text' => $comment->body]);
        $scoreToChange = \factory(ItemScore::class)->create(['item_id' => $item, 'exam_id' => $exam2, 'comment_text' => $comment->body]);

        //call
        $this->object->handleUpdateDefaults($exam2, $comment, $newText);

        //check
        $s1 = ItemScore::where('id', $unchangedScore->id)->first();
        $this->assertEquals($comment->body, $s1->comment_text, "Comment text on other exams not updated");
        $s2 = ItemScore::where('id', $scoreToChange->id)->first();
        $this->assertEquals($newText, $s2->comment_text, "Comment text on current exam was updated");
    }

}