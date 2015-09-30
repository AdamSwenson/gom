<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Question;
use App\Exam;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\IQuestionRepository;

class QuestionController extends Controller
{
    //use ValidatesRequests;

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
    protected $questions;
    protected $requestIds;

    /** @var IQuestionAssignmentRepository */
    private $assignmentDao;

    public function __construct(IQuestionRepository $questionDao, IQuestionAssignmentRepository $assignmentDao)
    {
        $this->middleware('auth');
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
        //load all questions for exam
        if ($request->has('examId')) {
            $exam = Exam::findOrFail($request->input('examId'));
            //Check that user owns the exam
            $this->authorize('access-object', $exam);

            $questions = $this->assignmentDao->load_all_for_exam($request->input('examId'));
        } // load all questions for class
        elseif ($request->has('classId')) {
            $questions = $this->questionDao->loadQuestionsByClassId($request->input('classId'));
        } // load all questions for session user
        else {
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
        abort(403);
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
        //Check that user owns the exam
        $exam = Exam::findOrFail($request->input('examId'));
        $this->authorize('access-object', $exam);

        //store and return the question
        $question = $this->questionDao->createQuestion(
            $request->input('questionName'),
            $request->input('questionDesc'),
            $request->input('maxScore'));

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
     * @param QuestionResponse $question
     * @return Response
     */
    public function show(QuestionResponse $question)
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

        return view('', compact('question'));
    }

    /**
     * Update the specified question in storage.
     *
     * @param Question $question
     * @param QuestionRequest $request
     * @return Response
     */
    public function update(Question $question, QuestionRequest $request, $returnView = true)
    {
        //Check that user owns the question
        $this->authorize('alter-object', $question);

        $question = $this->questionDao->updateQuestionObject(
            $question,
            $request->input('questionName'),
            $request->input('questionText'),
            $request->input('maxScore'));

        if ($returnView) {
            //TODO: Add view here
            return view('', compact('question'));
        }
    }

    /** Update all questions passed in by $request and set order assignments
     *  If a question has id=0 a new question will be created
     *
     *  NOTE: Right now, all existing questions in a form have their full contents updated every time
     * the edit_questions form is submitted by the user. The 'updated_at' field thus reflects
     * the last time the question was in a group of items saved, not necessarily when the item was modified.
     *
     * @param $exam
     * @param QuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAll(Exam $exam, QuestionRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('alter-object', $exam);

        $examId = $exam->getId();

        //Do all the heavy lifting...
        $this->assignmentDao->updateAll($exam, $request);

        // If someone deletes all questions and defeat checks, redirect back to exam select...
        $checkIfEmpty = $this->assignmentDao->load_all_for_exam($examId);
        if (!count($checkIfEmpty)) {
            return redirect()->action('ExamController@index');
        }
        // ...because this line will crash if there is no question #1
        $firstQuestionAssign = $this->assignmentDao->load($examId, 1);
        $firstQId = $firstQuestionAssign->getQuestionId();
        $firstQuestionObject = $this->questionDao->loadQuestionById($firstQId);

        if ($request->input('nextAction') == 'editExam') {
            return redirect()->action('ExamController@edit', ['exam' => $exam]);
        } else {
            return redirect()->action('ElementController@editAll', array('examId' => $examId,
                'question' => $firstQuestionObject));
        }
    }

    /** Get all questions $exam obj and send to edit_question view
     * @param $exam
     * @return $this
     */
    public function editAll($exam)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        $assignments = $this->assignmentDao->load_all_for_exam($exam->getId());
        $questions = [];

        foreach ($assignments as $ass) {
            $id = $ass->question_id;
            // load the question with given id by its index: ['0','1', ...]
            $questions[] = $this->questionDao->loadQuestionById($id);
        }
        $examName = $exam->getName();
        $examId = $exam->getId();

        return view('setup.edit_question')->with([
            'questions' => $questions,
            'examName' => $examName,
            'examId' => $examId]);
    }

    /**
     * Remove the specified question from storage.
     *
     * @param Exam $exam
     * @param Question $question
     * @return Response
     */
    public function destroy(Exam $exam, Question $question)
    {
        //Check that user owns the exam and question
        $this->authorize('alter-object', $exam);
        $this->authorize('destroy-object', $question);

        $questionObj = $this->questionDao->loadQuestionById($question);
        $result = $this->questionDao->deleteQuestionObject($questionObj);

        if (!empty($result)) {
            Session::flash(self::SUCCESS_FLASH_NAME, self::DELETE_SUCCESS);
        } else {
            Session::flash(self::FAIL_FLASH_NAME, self::DELETE_FAIL);
        }

        return view('Destroyed Question #' . $result);

    }


}
