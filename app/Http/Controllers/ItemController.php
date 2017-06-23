<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Element;
use App\Exam;
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
        //dev
        Auth::loginUsingId(1);

//        $this->middleware('auth');
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
        $exam = Exam::create();
        return redirect()->route('show-exam', $exam);
//        $v = new Wine();
//        $v->save();
//        return $v;
//        return $this->show($exam);
//        return view('development.newsetup');
    }


    /**
     * Store a newly created resource in storage.
     *
     * That is, create new Exam, Question, or Element depending on the
     * index and depth, associating them with an exam as
     * in the usual models
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( ItemRequest $request )
    {

        //find the item or create a new one
        $item = Item::where(['id' => $request->input('id')])->first();
        if ( !$item ) {
            $item = Item::create();
            //     $item->user()->save(Auth::user());
        }
        //update its properties
        $item->update(
            ['text' => $request->input('text'),
                'name' => $request->input('name'),
                'max_score' => $request->input('maxScore')
            ]);
        return $item;

//        return $this->itemRepository->handleStoreAndUpdate($request);
    }


    /**
     * Display the specified exam.
     * We use the show route to dependency inject an exam
     * Thus this route should not be used for question and element items
     *
     * Called on the route:
     *      GET    /items/{exam}    show    items.show
     *
     * @param Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function show( Exam $exam ) //Item $item, ItemRequest $request )
    {
        $itemObjects = [];
        $itemOrder = [];

        $assignments = Assignment::where('exam_id', $exam->id)->get();
        foreach ( $assignments as $assignment ) {
            $item = Item::where('id', $assignment->item_id)->first();
            if ( $item ) {
                $itemObjects[] = $item;
                $parentItemAssignment = $assignment->getParent();//Assignment::where('parent_id', $assignment->parent_id)->first();

                $parentItemId = $parentItemAssignment ? $parentItemAssignment->item_id : null;

                $itemOrder[] = [
                    'examId' => $exam->id,
                    'itemId' => $item->id,
                    'parentId' => $parentItemId,
                    'itemOrder' => $assignment->position
                ];
            }
        }

        $out = [
            'examObjectJsonName' => self::EXAM_JSON_NAME,
            'itemObjectJsonName' => self::ITEM_OBJECT_JSON_NAME,
            'itemOrderJsonName' => self::ITEM_ORDER_JSON_NAME,
            'exam' => $exam,
            'itemObjects' => $itemObjects,
            'itemOrder' => $itemOrder
        ];
        return view('development.newsetup', $out);
    }

    public function thePreviousVersionOfshow( Exam $exam )
    {//Item $item, ItemRequest $request )

        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());
        foreach ( $questionAssignments as $qAssignment ) {
            $index = $qAssignment->getQuestionNumber();
            $question = $qAssignment->getQuestion();
            $items[$index] = $question;
            //$allElements[] = $this->elementAssignmentDao->load_elements($exam->getId(), $index);
            //['maxScore' => $question->maxScore, 'name' => $question->name, 'id' => $question->id];
        }
//        get items
//         load all current student scores & comments
        $allElementAssignments = $this->elementAssignmentDao->load_by_exam($exam->getId());
        $out = [
            'exam' => $exam,
        ];

        return view('development.newsetup', $out);

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
     * @param Item $item
     * @param ItemRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function update( Item $item, ItemRequest $request )
    {
        //update its properties
        $item->update(
            ['text' => $request->input('text'),
                'name' => $request->input('name'),
                'max_score' => $request->input('maxScore')
            ]);
        return $item;

        //return $this->itemRepository->handleStoreAndUpdate($request);
    }


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


    /**
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


    /**
     * Remove the specified resource from storage.
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy( ItemRequest $request )
    {
        $this->determineItemType($request);

        switch ( $this->type ) {
            case Exam::class:
                break;

            case Element::class:
                //make new element
                break;

            case Question::class;
                //make new question
                break;
        }
    }


}
