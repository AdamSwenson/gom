<?php


namespace App\Repositories\Item;


use App\Comment;
use App\Item;
use App\ItemComment;
use App\Models\NewGom\ItemScore;
use App\Student;

class ItemCommentRepositoryTest extends \TestCase
{

    public $item;
    public $exam;
    public $comments = [];
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ItemCommentRepository;
    }

    /**
     * Sets up item comments for testing
     *
     */
    public function makeItemComments()
    {
        $this->item = factory(Item::class)->create();
        foreach ( ItemCommentRepository::$assignmentCriteria as $k => $v ) {

            //make the expected comments
            $c = new ItemComment();
            $c->item()->associate($this->item->id);
            $valence = ItemComment::textValenceFromNumber($k);
            $c->valence = $valence;
            $text = $this->faker->sentence();
            $c->body = $text;
            $c->save();

            $this->comments[] = $c;
        }
    }

    /** @test */
    public function getCommentForValence()
    {
        $item = factory(Item::class)->create();
        foreach ( ItemCommentRepository::$assignmentCriteria as $k => $v ) {

            //make the expected comments
            $c = new ItemComment();
            $c->item()->associate($item->id);
            $valence = ItemComment::textValenceFromNumber($k);
            $c->valence = $valence;
            $text = $this->faker->sentence();
            $c->body = $text;
            $c->save();

            //call
            $result = $this->object->getCommentForValence($item->id, $valence);

            $this->assertNotEmpty($result);
            $this->assertEquals($text, $result->body);
        }

    }

//    public function testGetCommentForScore()
//    {
//
//    }

    public function testMakeCutoffsFromMaxScore()
    {
        $score = 100;
        $expect = [0, 34, 67, 100];

        //call
        $result = $this->object->makeCutoffsFromMaxScore($score);

        //check
        $i = 0;
        foreach ( $result as $k => $v ) {
            $this->assertEquals($expect[$i], $v);
            $this->assertEquals(Comment::$valences[$i], $k);
            $i++;
        }
    }

    /** @test */
    public function chooseValenceByScoreReturnsCorrectValence()
    {
        foreach ( ItemCommentRepository::$assignmentCriteria as $k => $v ) {
            $score = $v - 1;
//            $score = $v['maxScore'] - 1;

            //call
            $result = $this->object->chooseValenceByScore($score);

            //check
            $this->assertEquals($k, $result);
        }

    }

    /** @test */
    public function assignDefaultCommentsToGradedItems()
    {
        //This item score should have a filled in comment
        //and thus should not be messed with
        $score = factory(ItemScore::class)->create();
        $score->save();
        $exam = $score->exam;
        $item = $score->item;
        $item->max_score = 10;
        $item->save();
        $unchangedComment = $score->comment_text;
        $score1Id = $score->id;
        $exam->addAssignment($item, $exam->id, 0);
        $exam->save();


        foreach ( ItemCommentRepository::$assignmentCriteria as $k => $v ) {
            //This comment will have the comment be null
            $student2 = factory(Student::class)->create();
            $score2 = new ItemScore();
            $score2->exam()->associate($exam->id);
            $score2->item()->associate($item->id);
            $score2->student()->associate($student2->id);
            $score2->save();
            $score2Id = $score2->id;

            //create the relevant comment
            $comment = new ItemComment();
            $comment->item()->associate($item->id);
            $comment->valence = $k;
            $comment->body = $this->faker->sentence();
            $comment->save();

            //set the score which should garner the comment
            //on both of our score objects;
            $scoreVal = $v - 1;
            $score->score = $scoreVal;
            $score->save();
            $score2->score = $scoreVal;
            $score2->save();

            $itemScores = ItemScore::where('exam_id', $exam->id)
                ->where('item_id', $item->id)
                ->whereNotNull('score')
                ->whereNull('comment_text')
                ->get();

            //call
            $this->object->assignDefaultCommentsToGradedItems($exam);

            //check
            //load the 2 score objects
            $s1 = ItemScore::where('id', $score1Id)->first();
            $s2 = ItemScore::where('id', $score2Id)->first();

            //check has not updated where comment text was not null
            $this->assertEquals($unchangedComment, $s1->comment_text, "The score with pre-existing comment has not been changed");
            $this->assertEquals($comment->body, $s2->comment_text, "The score without pre-existing comment has updated");


        }


    }

}
