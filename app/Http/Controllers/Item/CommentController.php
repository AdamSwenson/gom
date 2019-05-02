<?php

namespace App\Http\Controllers\Item;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemCommentRequest;
use App\Item;
use App\ItemComment;
use App\Models\NewGom\ItemScore;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Item\IItemRepository;
use App\Repositories\Student\IStudentRepository;
use Illuminate\Http\Request;

/**
 * Class CommentController
 *
 * This handles updates etc to the comments
 * associated with an item.
 * It never deals with a comment by itself.
 *
 * @package App\Http\Controllers\Item
 */
class CommentController extends Controller
{


    /**@var IExamRepository */
    protected $examDao;
    /**@var IQuestionRepository */
    protected $questionDao;
    /** @var IQuestionAssignmentRepository */
    protected $questionAssignmentDao;
    protected $questions;
    protected $requestIds;
    /** @var IStudentRepository */
    protected $studentDao;
    /** @var IElementRepository */
    protected $elementDao;
    /** @var IElementAssignmentRepository */
    protected $elementAssignmentDao;
    /** @var IItemRepository */
    protected $itemRepository;

    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store or update the comment associated with a particular
     * item's valence.
     *
     * POST
     *
     * The ItemCommentRequest object handles validation
     * The controller assumes that all incoming data in the
     * request is good to go
     *
     * @param Item $item
     * @param ItemCommentRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Item $item, ItemCommentRequest $request )
    {
        try {
            foreach ( $request->input('comments') as $row ) {
                $incomingValence = $row[0];
                $incomingComment = $row[1];

                //Try loading the comment
                $comment = $item->comments()->where(['valence' => $incomingValence])->first();

                if ( !isset($comment) ) {
                    $i = Item::find($request->input('itemId'));
                    $comment = new ItemComment();
                    $comment->valence = $incomingValence;
                    $comment->item_id = $i->id;
                    $comment->save();
                }

                //update it
                if ( isset($incomingComment['text']) ) {
                    /*
                     * Some fields should be reset to null if the existing value
                     * is deleted on the client. However, the incoming
                     * request will have an empty string. This casts
                     * such strings to null. See GOM-394
                     */
                    $text = empty($incomingComment['text']) ? null : $incomingComment['text'];

                    //Check if the overwrite default flag is
                    //enabled.
                    if ( $request->has('overwriteDefaults') && $request->has('examId') ) {
                        $exam = Exam::where('id', $request->input('examId'))->first();
                        $this->handleUpdateDefaults($exam, $comment, $text);

                    }

                    $comment->update(['body' => $text]);
                }

            }

        } catch (Exception $e) {
            return $this->sendAjaxFailure();
        }
        return $this->sendAjaxSuccess();

    }


    /**
     * Return all comments for a given item.
     *
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function show( Item $item )
    {
        return $item->comments()->all();
    }

    /**
     * Helper function. Used if the user wants to update all default comments which have
     * been assigned to the student with a new comment.
     * This must be injected prior to the old comment being
     * updated.
     * @param $exam
     * @param $oldComment
     * @param $newText
     */
    public function handleUpdateDefaults( Exam $exam, ItemComment $oldComment, $newText )
    {
        //check whether the comment text has been updated
        //This is needed because the overwrite defaults flag
        //gets set on the request as a whole, which means all
        //valences of existing comments will be included even if
        //only one has been altered. We do not want to iterate through
        //unneeded valences
        if ( $oldComment->body !== $newText ) {

            $itemScores = ItemScore::where('exam_id', $exam->id)
                ->where('item_id', $oldComment->item->id)
                ->get();

            foreach ( $itemScores as $score ) {
                if ( !is_null($score->comment_text) && $score->comment_text === $oldComment->body ) {
                    $score->comment_text = $newText;
                    $score->save();
                }
            }
        }
    }


}
