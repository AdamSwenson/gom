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
        //load all questions for exam
        if ($request->has('examId')) {
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
     * @param QuestionResponse $question
     * @return Response
     */
    public function show(QuestionResponse $question)
    {
        dd($question);
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
        $question = $this->questionDao->updateQuestionObject($question, $request->input('questionName'),
            $request->input('questionText'));
        if ($returnView) {
            //TODO: Add view here
            return view('', compact('question'));
        }
    }

    /** Update all questions passed in by $request and set order assignments
     *  If a question has id=0 a new question will be created
     *
     * @param $exam
     * @param QuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAll($exam, QuestionRequest $request)
    {
        // NOTE: Right now, all existing questions in a form have their full contents updated every time
        // the edit_questions form is submitted by the user. The 'updated_at' field thus reflects
        // the last time the question was in a group of items saved, not necessarily when the item was modified.

        $examId = $exam->getId();

        // Process uploaded form: Update questions and create new questions as necessary
        $currentQuestions = [];
        $i = 1;
        while ($request->input('questionName' . $i)) {
            // new questions arrive with id == 0
            if (($request->input('questionId' . $i)) == 0) {
                $question = $this->questionDao->createQuestion($request->input('questionName' . $i),
                    $request->input('questionText' . $i));
                $this->assignmentDao->record($examId, $question->getId(), $i);
            } else
            // other items already exist and should be updated
            {
                $question = $this->questionDao->updateQuestion($request->input('questionId' . $i),
                    $request->input('questionName' . $i), $request->input('questionText' . $i));
                $this->assignmentDao->record($examId, $request->input('questionId' . $i), $i);
            }
            $currentQuestions[$question->getId()] = $question;
            $i++;
        }

        // Handle item deletion

        // NOTE: any questions associated with this exam that weren't submitted with the form are deleted.
        $oldQuestions = $this->assignmentDao->load_all_for_exam($examId);
        if (!count($oldQuestions)) {
            foreach ($oldQuestions as $oldQuestion) {
                $qIdToFind = $oldQuestion->question->getId();
                if (!array_key_exists($qIdToFind, $currentQuestions)) {
                    $this->questionDao->deleteQuestion($qIdToFind);
                }
            }
        }

        // If someone deletes all questions and defeat checks, redirect back to exam select...
        $checkIfEmpty = $this->assignmentDao->load_all_for_exam($examId);
        if ( !count($checkIfEmpty) ) {
            return redirect()->action('ExamController@index');
        }
        // ...because this line will crash if there is no question #1
        $firstQuestionAssign = $this->assignmentDao->load($examId, 1);
        $firstQId = $firstQuestionAssign->question_id;
        $firstQuestionObject = $this->questionDao->loadQuestionById($firstQId);

        return redirect()->action('ElementController@editAll', array('examId' => $examId,
            'question' => $firstQuestionObject));

    }

    /** Get all questions $exam obj and send to edit_question view
     * @param $exam
     * @return $this
     */
    public function editAll($exam)
    {
        $assignments = $this->assignmentDao->load_all_for_exam($exam->getId());
        $questions = [];

        foreach ($assignments as $ass) {
            $id = $ass->question_id;
            // load the question with given id by its index: ['0','1', ...]
            $q['qObj'] = $this->questionDao->loadQuestionById($id);
            $questions[] = $q;
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
     * @param Question $question
     * @return Response
     * @throws \Exception
     */
    public function destroy($exam, $question)
    {
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
