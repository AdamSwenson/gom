<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemCommentRequest;
use App\Item;
use App\ItemComment;
use App\Repositories\Item\IItemCommentRepository;
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
     * @var IItemCommentRepository
     */
    private $commentRepository;

    /**
     * CommentController constructor.
     * @param IExamRepository $examDao
     * @param IStudentRepository $studentDao
     * @param IItemRepository $itemRepository
     * @param IItemCommentRepository $commentRepository
     */
    public function __construct(
        IExamRepository $examDao,
        IStudentRepository $studentDao,
        IItemRepository $itemRepository,
        IItemCommentRepository $commentRepository
    )
    {
        $this->middleware('auth');
        $this->examDao = $examDao;
        $this->itemRepository = $itemRepository;
        $this->commentRepository = $commentRepository;
        $this->studentDao = $studentDao;
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
                $comment->update(['body' => $incomingComment['text']]);
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

}
