<?php

namespace App\Http\Controllers;

use App\Element;
use App\Exam;
use App\Http\Requests\ItemRequest;
use App\Item;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Question;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Exam\IExamRepository;
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
    private $elementDao;
    /**
     * @var IElementAssignmentRepository
     */
    private $elementAssignmentDao;


    public function __construct(
        IExamRepository $examDao,
        IElementRepository $elementDao,
        IElementAssignmentRepository $elementAssignmentDao,
        IQuestionAssignmentRepository $questionAssignmentDao,
        IStudentRepository $studentDao,
        IQuestionRepository $questionDao
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
    }

// ---------------------------------- Helpers

// ------------------------ particular methods
    public function handleExam( $request )
    {
        $term = $request->input('term') ? $request->input('term') : Carbon::now()->year;
        $year = $request->input('year') ? $request->input('year') : Carbon::now()->year;
        $name = $request->input('name') ? $request->input('name') : 'Unnamed -- created: ' . Carbon::now()->toDayDateTimeString();
        $exam = $this->examDao->save_new_exam($year, $term, $name);

        if ( $exam ) {
            $this->dispatch(new UpdateAllStoredExamStats());
        }
        $exam->index = 0;
        return $exam;
    }

    public function handleQuestion( $request )
    {

        //Check that user owns the exam
//        $exam = Exam::findOrFail($request->input('examId'));
        //$this->authorize('access-object', $exam);

        //store and return the question
        $question = $this->questionDao->createQuestion($request->input('name'),
            $request->input('text'),
            $request->input('maxScore'));

        //associate it with the exam
//        $questionAssignment = $this->questionAssignmentDao->record($request->input('examId'), $question->getId(),
        //          $request->input('questionNumber'));

        return $question;
    }


// -------------------------------- Controller methods


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('development.newsetup');
    }

    /**
     * the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        //
//    }

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

        return $this->handleStoreAndUpdate($request);
    }


    /**
     * Display the specified exam.
     * We use the show route to dependency inject an exam
     * Thus this route should not be used for question and element items
     *
     * Called on the route:
     *      GET    /items/{exam}    show    items.show
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function show( Exam $exam ) //Item $item, ItemRequest $request )
    {
        $items = [];

        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());
        foreach ( $questionAssignments as $qAssignment ) {
            $index = $qAssignment->getQuestionNumber();
            $question = $qAssignment->getQuestion();
            $items[$index] = $question;
            //$allElements[] = $this->elementAssignmentDao->load_elements($exam->getId(), $index);


            //['maxScore' => $question->maxScore, 'name' => $question->name, 'id' => $question->id];
        }
        //get items
        // load all current student scores & comments
        //       $allElementAssignments = $this->elementAssignmentDao->load_by_exam($exam->getId());

        return view('development.newsetup', ['exam' => $exam, 'items' => $items]);
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
//        $exam = Exam::find($item->id);
//        return view('development.newsetup', ['exam' => $exam]);
//But it should've been overridden in routes/web so is actually:
//        *      GET    /items/{exam}/edit    edit    items.edit
//    *
    }

    /**
     * Receives PUT
     * Updates the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update( ItemRequest $request )
    {
        return $this->handleStoreAndUpdate($request);
    }


    /**
     * This handles updating the order etc when passed
     * the list of items.
     * Receives PATCH
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateAll( Exam $exam, ItemRequest $request )
    {
        if ( $request->has('itemsList') ) {

            $this->questionAssignmentDao->updateAll($exam, $request);
            return $this->questions;
        }
//        return $this->handleStoreAndUpdate($request);
    }



    public function updateOrder(  $exam, ItemRequest $request )
    {
        //this should probably be a job
        //it can run async. The client doesn't really need to know what's
        //going on as long as the server catches up.
        //Separating the item data from the positional/assignment info
        //lets this be separated off into a job if we want...
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

    /**
     * @param ItemRequest $request
     * @return Item|array
     */
    protected function handleStoreAndUpdate( ItemRequest $request )
    {

        //This will create the item if it didn't exist and
        //update it otherwise.
        $item = Item::loadItemFromRequest($request);

//        if ( $item ) {

        //Now we need to do anything specific based on
        //the kind of OG model the item represents.
        switch ( $item ) {

            case $item instanceof Question:
                if ( !$request->has('examId') ) {
                    //stop here if no exam id was sent
                    return $item;
                }

                //translate the idx into the OG question number
                $questionNumber = $request->has('idx') ? $request->input('idx')[0] : $request->input('index');

                //now we need to make sure the associations are taken care of
                //that is, we need to map the idx from the $request to the
                //question and element assignments
                //associate it with the exam
                $assignment = $this->questionAssignmentDao->record($request->input('examId'), $item->id, $questionNumber);

                //store the question assignment id in the item
                $item->questionAssignment = $assignment;
                return $item;

                break;

            case $item instanceof Element:

                break;

            case $item instanceof Exam:
//                    $this->dispatch(new UpdateStoredExamStats($exam));
//
                $this->dispatch(new UpdateAllStoredExamStats());

                return $item;
                break;
            default:
                //if there was nothing special to do
                //or no item was created, fall through
        }
//        }
        return $item;
    }


}
