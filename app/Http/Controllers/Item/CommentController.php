<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Item;
use App\ItemComment;
use App\Repositories\Element\IItemCommentRepository;
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
     * @param Item $item
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Item $item, Request $request )
    {
        try {
            $valence = $request->has('valence') ? $request->input('valence') : null;

            //grab or create the comment
            $comment = ItemComment::firstOrCreate(['item_id' => $item->id, 'valence' => $valence]);

            //update it
            $comment->update(['body' => $request->input('text')]);

            return $this->sendAjaxSuccess();

        } catch (Exception $e) {
            return $this->sendAjaxFailure();
        }
    }

    /**
     * Return all comments for a given item.
     *
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function show( Item $item)
    {
        return $item->comments()->all();
    }

}
