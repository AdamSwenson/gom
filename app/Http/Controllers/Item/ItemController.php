<?php

namespace App\Http\Controllers\Item;

use App\Assignment;
use App\Element;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Item;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Question;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Item\IItemRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Student\IStudentRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class ItemController
 * @package App\Http\Controllers
 */
class ItemController extends Controller
{
    const EXAM_JSON_NAME = 'loadedExam';
    const ITEM_ORDER_JSON_NAME = 'loadedItemOrder';
    const ITEM_OBJECT_JSON_NAME = 'loadedItemObjects';
    public $type;
    public $exam;

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

    public function __construct(
        IExamRepository $examDao,
        IElementRepository $elementDao,
        IElementAssignmentRepository $elementAssignmentDao,
        IQuestionAssignmentRepository $questionAssignmentDao,
        IStudentRepository $studentDao,
        IQuestionRepository $questionDao,
        IItemRepository $itemRepository
    )
    {
        $this->middleware('auth');
        $this->examDao = $examDao;
        $this->questionAssignmentDao = $questionAssignmentDao;
        $this->studentDao = $studentDao;
        $this->questionDao = $questionDao;
        $this->elementDao = $elementDao;
        $this->elementAssignmentDao = $elementAssignmentDao;
        $this->itemRepository = $itemRepository;
    }



// -------------------------------- Controller methods

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::all(); //make sure inherits from base model!
    }


    /**
     * Store a newly created resource in storage.
     * POST
     * That is, create new Exam, Question, or Element depending on the
     * index and depth, associating them with an exam as
     * in the usual models
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( ItemRequest $request )
    {
//todo Separate this so that store only handles creation
        if ( $request->has('id') ) {
            //find the item
            $item = Item::find($request->input('id'));
        }
        //if we don't have an item yet, create one
        if ( !isset($item) ) {
            $item = Item::create();
        }

        //update its properties
        $item->update(
            [
                'text' => $request->input('text'),
                'name' => $request->input('name'),
                'max_score' => $request->input('maxScore')
            ]);
        return $item;

//        return $this->itemRepository->handleStoreAndUpdate($request);
    }


    /**
     * Display the specified item.
     * We use the show route to dependency inject an exam
     * Thus this route should not be used for question and element items
     *
     * Called on the route:
     *      GET    /items/{exam}    show    items.show
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function show( ItemRequest $request )
    {
        return $request->has('id') ? Item::find($request->input('id')) : null;
    }

    /**
     * This route is used for getting question and element items
     *      GET    /items/{item}/edit    edit    items.edit
     * TODO Figure out what the fuck to do to get the item
     *
     * @param Item $item
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit( Item $item, ItemRequest $request )
    {
        return $item;
    }

    /**
     * Receives PUT
     * Updates the specified resource in storage.
     *
     *
     * Presently handled by store
     * @todo Update store so it only handles creation and update handles updates
     * @param Item $item
     * @param ItemRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function update( Item $item, ItemRequest $request )
    {
        //update its properties
        $item->update(
            [
                'text' => $request->input('text'),
                'name' => $request->input('name'),
                'max_score' => $request->input('maxScore')
            ]);
        $item->save();
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return \Illuminate\Http\Response
     * @internal param ItemRequest $request
     */
    public function destroy( Item $item )
    {
        try {
            $item->delete();
            return $this->sendAjaxSuccess();
        } catch (Exception $e) {
            return $this->sendAjaxFailure();
        }

        //
//        $this->determineItemType($request);
//
//        switch ( $this->type ) {
//            case Exam::class:
//                break;
//
//            case Element::class:
//                //make new element
//                break;
//
//            case Question::class;
//                //make new question
//                break;
//        }
    }


    /**
     * Receives PUT
     * Updates the specified resource in storage.
     *
     * @param Exam $exam
     * @param ItemRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function examUpdate( Exam $exam, ItemRequest $request )
    {
        //update its properties
        $exam->update(
            [
//                'text' => $request->input('text'),
                'name' => $request->input('name'),
//                'max_score' => $request->input('maxScore')
            ]);
        return $exam;

        //return $this->itemRepository->handleStoreAndUpdate($request);
    }





    /*
     *
     * KEEP THE BELOW FOR THE HYBRID API!!!!!
     *
     *
     *
     */


    /**
     * //Old version: KEEP FOR HYBRID API
     * @param Exam $exam
     * @param ItemRequest $request
     * @return mixed
     */
    public function updateOrder( Exam $exam, ItemRequest $request )
    {
//        Separating the item data from the positional/assignment info
//    * lets this be separated off into a job if we want...
//     *
        //this should probably be a job
        //it can run async. The client doesn't really need to know what's
        //going on as long as the server catches up.

        if ( $request->has('order') ) {
            $existingIds = $this->questionAssignmentDao->updateItemOrder($exam, $request->input('order'));

            return $existingIds;
        }
//        return $this->handleStoreAndUpdate($request);
    }

    //OLD UPDATE
    //return $this->itemRepository->handleStoreAndUpdate($request);

    /**
     * This handles updating the order etc when passed
     * the list of items.
     * Receives PATCH
     *
     * @param Exam $exam
     * @param ItemRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateAll( Exam $exam, ItemRequest $request )
    {
        if ( $request->has('itemsList') ) {
            $this->questionAssignmentDao->updateAll($exam, $request);
            return $this->questionAssignmentDao->questions;
        }
    }


}
