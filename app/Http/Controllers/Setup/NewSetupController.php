<?php

namespace App\Http\Controllers\Setup;

use App\Assignment;
use App\Element;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Item;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Kumi;
use App\Question;
use App\Repositories\Assignment\IAssignmentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Exam\INewExamRepository;
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
class NewSetupController extends Controller
{
    const DEFAULT_KUMI_NAME = 'Group 1';
    const EXAM_JSON_NAME = 'loadedExam';
    const ITEM_ORDER_JSON_NAME = 'loadedItemOrder';
    const ITEM_OBJECT_JSON_NAME = 'loadedItemObjects';
    const KUMIS_JSON_NAME = 'loadedKumis';

    public $type;
    public $exam;

    /**
     * NewSetupController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
//
//    protected function makeNewExam()
//    {
//        $exam = Exam::create();
//        //this is a brand new exam, so there are no
//        //kumis associated with it. So we create
//        //and empty one to be the default kumi
//        $kumi = Kumi::create(['name' => self::DEFAULT_KUMI_NAME]);
//        $kumi->is_roster = true; //make it the default roster
//        $exam->kumis()->attach($kumi->id);
//        $kumi->save();
//        return $exam;
//    }
//
//    /**
//     * Looks for an existing exam which meets all the
//     * following conditions:
//     *     Properties are all default
//     *     No associated items
//     *     No associated kumis or students
//     *     No associated notes
//     */
//    public function findEmptyExam()
//    {
//        $e = Exam::where('name', null)
//            ->where('public_name', null)
//            ->where('year', null)
//            ->where('term', null)->where('description', null)
//            ->doesntHave('assignments')//no items
//            ->doesntHave('notes')//no notes
//            ->withCount('kumis')
//            ->first();
//        if ( is_null($e) ) {
//            return $this->makeNewExam();
//        }
//
//        //every exam will have one kumi
//        if ( $e->kumis_count > 1 ) {
//            return $this->makeNewExam();
//        }
//
//        //now check if there are any students
//        $students = $e->roster()->students()->first();
//        if ( !is_null($students) ) {
//            return $this->makeNewExam();
//        }
//
//        return $e;
//    }

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
        $repo = app()->make(INewExamRepository::class);
        $emptyExams = $repo->getEmptyExams();

        $exam = sizeof($emptyExams) === 0 ? $repo->makeNewExam(self::DEFAULT_KUMI_NAME) : $emptyExams[0];
//        $exam = Exam::create();
//        //this is a brand new exam, so there are no
//        //kumis associated with it. So we create
//        //and empty one to be the default kumi
//        $kumi = Kumi::create(['name' => self::DEFAULT_KUMI_NAME]);
//        $kumi->is_roster = true; //make it the default roster
//        $exam->kumis()->attach($kumi->id);
//        $kumi->save();

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

        return view('new.newsetup', ['exam' => $exam]);

        /*
         * WE'VE MOVED TO THE SETUP PAGE LOADING THE DATA
         * VIA AJAX. KEEPING THIS HERE FOR REFERENCE IF
         * DECIDE TO GO BACK TO LOADING FROM PAGE JSON. ALSO
         * MAY BE USEFUL FOR THE FEEDBACK PAGE WHICH WILL NOT
         * USE AJAX

                $out = $this->assignmentRepository->getItemOrderForClient($exam);
                //The returned array  will have the keys
                //  'itemObjects'
                //  'itemOrder'
                $kumis = $exam->kumis()->get();

                if ( $kumis->count() === 0 ) {
                    //if there isn't one, we need it
                    $kumi = Kumi::create();
                    $exam->kumis()->attach($kumi->id);
                    $kumis = $exam->kumis()->get();
                }

                //So we add some additional elements that the page expects
                $standard = [
                    'examObjectJsonName' => self::EXAM_JSON_NAME,
                    'itemObjectJsonName' => self::ITEM_OBJECT_JSON_NAME,
                    'itemOrderJsonName' => self::ITEM_ORDER_JSON_NAME,
                    'kumisJsonName' => self::KUMIS_JSON_NAME,
                    'exam' => $exam,
                    'kumis' => $kumis];

                $out += $standard;

                return view('development.newsetup', $out);
        */
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

        return view('new.newsetup', $out);

    }


}
