<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Element;
use App\Exam;
use App\Http\Requests\ElementRequest;
use App\Question;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;

use App\Http\Requests;

class ElementController extends Controller
{
    /**
     * @var IElementRepository
     */
    private $elementDao;
    /**
     * @var IElementAssignmentRepository
     */
    private $assignmentDao;

    /**
     * ElementController constructor.
     * @param IElementRepository $elementDao
     * @param IElementAssignmentRepository $assignmentDao
     * @param IQuestionAssignmentRepository $questionAssignmentDao
     */
    public function __construct(IElementRepository $elementDao,
                                IElementAssignmentRepository $assignmentDao,
                                IQuestionAssignmentRepository $questionAssignmentDao)
    {
        $this->middleware('auth');
        $this->elementDao = $elementDao;
        $this->assignmentDao = $assignmentDao;
        $this->questionAssignmentDAO = $questionAssignmentDao;
    }

    /**
     * Display a listing of the resource.
     * @param ElementRequest $request
     * @return Response
     */
    public function index(ElementRequest $request)
    {
        if (!empty($questionId)) {
        } else {
            return Element::all();
        }
        //$element = $this->dao->loadElementById($elementId);
        //return $element;
        //for question number
        return $this->dao->load_element_assignments_by_question_number($request->input('exam_id'), $request->input('question_number'));
        // return ('List of elements for question id: '.$question);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ElementRequest $request
     * @return Response
     */
    public function create(ElementRequest $request)
    {
        //todo add view
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ElementRequest $request
     * @return Response
     */
    public function store(ElementRequest $request)
    {

        $elementName = $request->input('elementName');
        $respGeneric = $request->input('respGeneric');
        $element = $this->dao->createElement($elementName, '', $respGeneric);

        if (!empty($element)) {
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_ABSENT, $request->input('respAbsent'));
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_POOR, $request->input('respPoor'));
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_OK, $request->input('respFair'));
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_EXCELLENT, $request->input('respGood'));

            $this->assignmentDao->record($request->input('examId'), $request->input('questionNumber'), $element->getId(), $request->input('subtask'));
        }
        return $element;
    }

    /**
     * Display the specified resource.
     *
     * @param  Element $element
     * @return Response
     */
    public function show(Element $element)
    {
        //$element = $this->dao->loadElementById($elementId);
        //return $element;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Element $element
     * @param ElementRequest $request
     * @return Response
     */
    public function edit(Element $element, ElementRequest $request)
    {}

    /** Edit all elements associated with given question
     * @param Exam $exam
     * @param Question $question
     * @return Response
     */
    public function editAll($exam, $question)
    {
        $questionId = $question->getId();
        $examId = $exam->getId();
        $allQuestionAss = $this->questionAssignmentDAO->load_all_for_exam($examId);
        $qNumber = $this->questionAssignmentDAO->loadQuestionNumberById($examId, $questionId);

        // given the current $question, find previous and next $questionId...
        // loadByIds() will loop if the same questionId appears several times on the same exam,
        // as it matches with the first Id found in the ordered Assignments.
        $index = 0;
        foreach ($allQuestionAss as $questionAss) {
              if ($questionId === $questionAss->question_id) {
                break;
            } else {
                $index++;
            }
        }

        // once we found the index, get the question IDs for the previous and next questions
        // if previous or next does not exist, set to 0.
        $pQId = 'editQuestions'; // 'edit_questions'
        $nQId = 'editStudents'; // 'edit_roster'
        if (isset($index)) {
            if ($index < count($allQuestionAss) - 1) {
                $next = $allQuestionAss[$index + 1];
                $nQId = $next->question_id;
            }
            if ($index > 0) {
                $prev = $allQuestionAss[$index - 1];
                $pQId = $prev->question_id;
            }
        }
        // load data for any existing elements
        $elements = $this->assignmentDao->load_elements($examId, $qNumber);


        // show all elements for a given question along with the ids for 'next' and 'previous'
        return view('setup.edit_element')->with(['examId' => $examId,
            'nextAction' => $nQId,
            'prevAction' => $pQId,
            'questionId' => $questionId,
            'qNumber' => $qNumber,
            'questionName' => $question->getQuestionName(),
            'elements' => $elements ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Element $element
     * @param ElementRequest $request
     * @return Response
     */
    public function update(Element $element, ElementRequest $request)
    {}

    /**
     * Update all elements passed in from the web form.
     * Has 3 possible routes: back to EditQuestion, forward to EditRoster or to editElements (new question)
     *
     * @param Exam $exam
     * @param Question $question
     * @param ElementRequest $request
     * @return Response
     */
    public function updateAll(Exam $exam, Question $question, ElementRequest $request)
    {
        $this->assignmentDao->updateAll($exam, $question, $request);
        $examId = $exam->getId();

        /* Choose next action based on 'nextAction' param:
            1. go back to QuestionController
            2. go forward to StudentController
            3. load another question for element editing
        */
        $nextAction = $request->input('nextAction');
        if ($nextAction === 'editQuestions') {
            return redirect()->route('editAllQuestions', $examId);
        } else if ($nextAction === 'editStudents') {
            return redirect()->route('editAllStudents', $examId);
        } else {
            return redirect()->action('ElementController@editAll', array('examId' => $examId,
                'question' => $nextAction));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Element $element
     * @return Response
     * @internal param int $id
     */
    public function destroy(Element $element)
    {

    }
}
