<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\IQuestionRepository;

class QuestionController extends Controller
{
    const SUCCESS_FLASH_NAME = "flash_message_success";
    const FAIL_FLASH_NAME = "flash_message_fail";

    const CREATE_SUCCESS = "Successfully created question";
    const CREATE_FAIL = "There was a problem creating the question";

    const UPDATE_SUCCESS = "Successfully updated the question";
    const UPDATE_FAIL = "There was a problem updating the question";

    const DELETE_SUCCESS = 'you have successfully destroyed a question. I hope you are proud of yourself.';
    const DELETE_FAIL = 'There was a problem deleting the question';

    /**@var IQuestionRepository */
    protected $questionDao;

    /** @var IQuestionAssignmentRepository */
    private $assignmentDao;

    public function __construct(IQuestionRepository $questionDao, IQuestionAssignmentRepository $assignmentDao)
    {
        $this->questionDao = $questionDao;
        $this->assignmentDao = $assignmentDao;
    }

    /**
     * Display a listing of the resource.
     * @param QuestionRequest $request
     * @return Response
     */
    public function index(QuestionRequest $request)
    {

        if ($request->has('examId'))
        {
            $questions = $this->assignmentDao->load_all_for_exam($request->input('examId'));
        } elseif ($request->has('classId'))
        {
            $questions = $this->questionDao->loadQuestionsByClassId($request->input('classId'));
        } else
        {
            $questions = $this->questionDao->loadAll();
        }

        return $questions;

        //Todo View receiving questions
//        return ('List of all questions for exam #'.$exam);
    }

    /**
     * Show the form for creating a new resource.
     * @param QuestionRequest $request
     * @return Response
     */
    public function create(QuestionRequest $request)
    {
        // $exam from URL: questions must know which exam to be associated with(?)
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionRequest $request
     * @return Response
     */
    public function store(QuestionRequest $request)
    {
        //store and return the question
        $question = $this->questionDao->createQuestion($request->input('questionName'),
            $request->input('questionDesc'));

        //associate it with the exam
        $questionAssignment = $this->assignmentDao->record($request->input('examId'), $question->getId(),
            $request->input('questionNumber'));

        //TODO: Add view here
        return view('', compact('questionAssignment'));
    }

    /**
     * Display the specified question.
     *
     * The model is bound to the route so the id does not
     * need to be specified as an argument here (though it still
     * needs to be in the route).
     *
     * @param Question $question
     * @return Response
     */
    public function show(Question $question)
    {
        //TODO: Add view here
        return view('', compact('question'));
    }

    /**
     * Show the form for editing the specified question.
     *
     * @param Question $question
     * @return Response
     */
    public function edit(Question $question)
    {
        //dd($request);
        // default data for dev purposes
        $q1 = [
            'qName' => 'teat name #1',
            'qDesc' => 'description 1 here',
            'qOrder' => 1,
            'qId' => 123
        ];

        $q2 = [
            'qName' => 'test name #2',
            'qDesc' => 'description 2 here',
            'qOrder' => 2,
            'qId' => 234
        ];

        $questions = [$q1, $q2];

        $examName = 'History 101 Exam 1, Fall 2015';
        $exam = 3;

        //return view('/setup/edit_question');
        return view('setup.edit_question')->with([
            'questions' => $questions,
            'examName' => $examName,
            'examId' => $exam
        ]);

//        return view('', compact('question'));
    }

    /**
     * Update the specified question in storage.
     *
     * @param Question $question
     * @param QuestionRequest $request
     * @return Response
     */
    public function update(Question $question, QuestionRequest $request, $returnView=true)
    {
        $question = $this->questionDao->updateQuestionObject($question, $request->input('questionName'),
            $request->input('questionText'));
        if ($returnView)
        {
            //TODO: Add view here
            return view('', compact('question'));
        }
    }

    public function updateAll($exam, Request $request)
    {
        // this function will take a request and process all the questions therein.
        /* it will:
            -Create a new question if the id is empty
            -update an existing question if the id exists
            -set the order property for each question
            -pass the first questionId and examId to ElementController@
        */
        $data['examId'] = $exam;
        $data['questionId'] = 1;

        return ('this is the edit element view for question #');
        //return view('setup.edit_element')->with(['data' => $data]);
    }

    public function editAll($exam)
    {
        $examId = $exam->getId();
        $examName = $exam->getName();
        return view('setup.edit_question')->with([ 'examId' => $examId,
            'examName' => $examName]);
    }

    /**
     * Remove the specified question from storage.
     *
     * @param Question $question
     * @return Response
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $result = $this->questionDao->deleteQuestionObject($question);

        if (!empty($result))
        {
            Session::flash(self::SUCCESS_FLASH_NAME, self::DELETE_SUCCESS);
        } else
        {
            Session::flash(self::FAIL_FLASH_NAME, self::DELETE_FAIL);
        }

        return view('');

    }
}
