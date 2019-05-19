<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 3:20 PM
 */

namespace App\Repositories\Item;


use App\Exam;
use App\ItemComment;
use App\Models\NewGom\ItemScore;

/**
 * Class ItemCommentRepository
 * This is the new version of the gom commenting
 * To avoid too many conflicts with the old system,
 * I've written it to the original interface
 *
 * @package App\Repositories\Element
 */
class ItemCommentRepository implements IItemCommentRepository
{
    static public $assignmentCriteria = [
        ItemComment::VALENCE_ABSENT => 0.25,
        ItemComment::VALENCE_BOTTOM => 4.0,
        ItemComment::VALENCE_MIDDLE => 6.9,
        ItemComment::VALENCE_TOP => 10.0
    ];
//        Comment::VALENCE_ABSENT => [
//            'minScore' => 0,
//            'maxScore' => 0.25
//        ],
//        Comment::VALENCE_POOR => [
//            'minScore' => 0.26,
//            'maxScore' => 4.0
//        ],
//        Comment::VALENCE_OK => [
//            'minScore' => 4.1,
//            'maxScore' => 6.9
//        ],
//        Comment::VALENCE_EXCELLENT => [
//            'minScore' => 7.0,
//            'maxScore' => 10.0
//        ]
//    ];


    /**
     * Returns the appropriate comment text for the score
     * @param $itemId
     * @param $score
     * @param bool $criteria
     * @return mixed
     * @throws \Exception
     */
    public function getCommentForScore( $itemId, $score, $criteria = false )
    {
        $valence = $this->chooseValenceByScore($score, $criteria);
        return $this->getCommentForValence($itemId, $valence);
    }


    public function getCommentForValence( $itemId, $valence )
    {
        $comment = ItemComment::where('valence', $valence)
            ->where('item_id', $itemId)
            ->first();
        return $comment;
    }


    /**
     * Determines which comment valence to load
     * @param $score
     * @param bool $criteria
     * @return int|string
     * @throws \Exception
     */
    public function chooseValenceByScore( $score, $criteria = false )
    {
        $criteria = $criteria ? $criteria : self::$assignmentCriteria;
        foreach ( $criteria as $k => $v ) {
            if ( $score <= $v ) //            if($score <= $v['maxScore'])
            {
                return $k;
            }
        }
        throw new \Exception('score out of range');
    }

    public function makeCutoffsFromMaxScore( $maxScore )
    {
        $cutoffs = [];
        //we subtract 1 to deal with the missing valence since it is
        //really 3 valences that we need to split the scores between
        $interval = floor($maxScore / (sizeof(ItemComment::$valences) - 1));

        foreach ( collect(ItemComment::$valences)->reverse() as $valence ) {
            $cutoffs[$valence] = $maxScore;
            $maxScore = $maxScore - $interval;
        }

        //Update the value of the missing valence
        $cutoffs[ItemComment::VALENCE_ABSENT] = 0;

        //We created the array in the reverse order
        //so flip the result back around
        return array_reverse($cutoffs);


    }

    /**
     * Go through all the graded items and assign the default
     * comment appropriate to the score when there is no comment
     * present.
     *
     * This is generally used when the comment set up is completed
     * after the grading has begun / been done.
     *
     * @param Exam $exam
     * @return mixed|void
     * @throws \Exception
     */
    public function assignDefaultCommentsToGradedItems( Exam $exam )
    {
        $items = $exam->getItems();

        foreach ( $items as $item ) {
            //We don't want to use the fallback cutoffs since
            //those may not conform to the custom-set max score of the item
            $criteria = $this->makeCutoffsFromMaxScore($item->max_score);

            //Get all scores which don't have a comment set
            $itemScores = ItemScore::where('exam_id', $exam->id)
                ->where('item_id', $item->id)
                ->whereNotNull('score')
                ->whereNull('comment_text')
                ->get();

            foreach ( $itemScores as $itemScore ) {
                //find the appropriate default comment
                $comment = $this->getCommentForScore($item->id, $itemScore->score, $criteria);
                if(isset($comment)) {
                    //set it on the item score object
                    $itemScore->comment_text = $comment->body;
                    $itemScore->save();
                }
            }

        }

    }

}