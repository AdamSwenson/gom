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

//
//        //The request will be coming in with potentially a few
//        //of the item fields filled in. However, we are only concerned with
//        //figuring out what kind of item is being requested and its relationships,
//        //and then creating those and returning the relevant ids so that
//        //they can be set on the client
//        $this->determineItemType($request);
//
//        switch ( $this->type ) {
//            case Exam::class:
//                return $this->handleExam($request);
//                //return new Exam();
//                //todo eventually should redirect and use common action or job
////                return redirect()->action('ExamController@store');
//                break;
//
//            case Element::class:
//                //todo eventually should redirect and use common action or job
//                //make new element
//                return new Element();
//                break;
//            case Question::class;
//                //make new question
//                //todo eventually should redirect and use common action or job
//                return $this->handleQuestion($request);
//                break;
//            default:
//                //todo add error
//        }


    /**
     * Display the specified resource.
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function show( ItemRequest $request )
    {

        return Item::loadItemFromRequest($request);
    }

    /**
     * Show the form for editing the exam with all its constituents.
     * GET    /items/{item}/edit    edit    items.edit
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit( Item $item, ItemRequest $request )
    {
        $exam = Exam::find($item->id);
        return view('development.newsetup', ['exam' => $exam]);

    }

    /**
     * Receives PUT/PATCH
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
