<?php

namespace App\Jobs\Comments;

use App\Exam;
use App\Item;
use App\Models\NewGom\ItemScore;
use App\Repositories\Item\IItemCommentRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * If the user wants to assign default comments to all
 * uncommented fields (i.e., if they write the comments after
 * grading), we will trigger this job
 * Class AssignDefaultCommentsToScores
 * @package App\Jobs\Comments
 */
class AssignDefaultCommentsToScores implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Item
     */
    private $item;
    /**
     * @var IItemCommentRepository
     */
    private $itemCommentRepository;
    /**
     * @var Exam
     */
    private $exam;

    /**
     * Create a new job instance.
     *
     * @param Exam $exam
     */
    public function __construct(Exam $exam)
    {
        $this->itemCommentRepository = app()->make(IItemCommentRepository::class);
        $this->exam = $exam;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->itemCommentRepository->assignDefaultCommentsToGradedItems($this->exam);
//
//        $items = $this->exam->getItems();
//
//        foreach($items as $item){
//            //We don't want to use the fallback cutoffs since
//            //those may not conform to the custom-set max score of the item
//            $criteria = $this->itemCommentRepository->makeCutoffsFromMaxScore($item->max_score);
//
//            //Get all scores which don't have a comment set
//            $itemScores = ItemScore::where('exam_id', $this->exam->id)
//                ->where('item_id', $item->id)
//                ->whereNotNull('score')
//                ->whereNull('comment_text')
//                ->get();
//
//            foreach($itemScores as $itemScore){
//                //find the appropriate default comment
//                $comment = $this->itemCommentRepository->getCommentForScore($item->id, $itemScore->score, $criteria);
//                //set it on the item score object
//                $itemScore->comment_text = $comment;
//            }

//        }

//
//        //if the max score is set, we need to dynamically create
//        //the cutoffs. Otherwise we'll use the defaults from the slider settings
//        // We start by figuring out how far apart the
//        //cutoffs need to be by dividing max possible score by the number of labels
//        let numLabels = sliderSettings.valenceLabels.length;
//
//    let cutoffs = (!_.isUndefined( maxScore )) ? makeCutoffsFromMaxScore( maxScore, numLabels ) : sliderSettings.valenceCutoffs;
//
//    if ( !checkInRange( score, cutoffs ) ) return null;
//
//    return getValenceIndex( score, cutoffs );


        //
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }
}
