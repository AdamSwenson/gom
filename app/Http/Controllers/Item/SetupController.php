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
use App\Repositories\Assignment\IAssignmentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Item\IItemCommentRepository;
use App\Repositories\Item\IItemRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Student\IStudentRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Handles the display of the setup page.
 * Nothing CRUD gets done here.
 * All of that is the responsibility of
 * the Item and Assignment controllers
 * @package App\Http\Controllers
 */
class SetupController extends Controller
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
    /**
     * @var IAssignmentRepository
     */
    private $assignmentRepository;
    /**
     * @var IItemCommentRepository
     */
    private $commentRepository;

    /**
     * SetupController constructor.
     * @param IExamRepository $examDao
     * @param IItemRepository $itemRepository
     * @param IAssignmentRepository $assignmentRepository
     * @param IItemCommentRepository $commentRepository
     */
    public function __construct(
        IExamRepository $examDao,
        IItemRepository $itemRepository,
        IAssignmentRepository $assignmentRepository,
        IItemCommentRepository $commentRepository )
    {
        $this->middleware('auth');
        $this->itemRepository = $itemRepository;
        $this->examDao = $examDao;
        $this->assignmentRepository = $assignmentRepository;
        $this->commentRepository = $commentRepository;
    }



// -------------------------------- Controller methods

    /**
     * Returns the setup page when no exam is requested
     * Creates an exam first and redirects to the usual
     * handler
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam = Exam::create();
        return redirect()->route('show-exam', $exam);
    }

    /**
     * Display the specified exam.
     *
     * Called on the route:
     *      GET    /setup/{exam}    show    items.show
     *
     * @param Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function show( Exam $exam )
    {

        $out = $this->assignmentRepository->getItemOrderForClient($exam);
        //The returned array  will have the keys
        //  'itemObjects'
        //  'itemOrder'

        //So we add some additional elements that the page expects
        $standard = [
            'examObjectJsonName' => self::EXAM_JSON_NAME,
            'itemObjectJsonName' => self::ITEM_OBJECT_JSON_NAME,
            'itemOrderJsonName' => self::ITEM_ORDER_JSON_NAME,
            'exam' => $exam];

        $out += $standard;

        return view('development.newsetup', $out);

    }

    //keep this for the hybrid api!!!!!!!
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


}
