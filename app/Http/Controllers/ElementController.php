<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Element;
use App\Http\Requests\ElementRequest;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
    public function __construct(IElementRepository $elementDao, IElementAssignmentRepository $assignmentDao,
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
//todo: add view
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
    {

    }

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
        $pQId = 0;
        $nQId = 0;
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
            'nextqId' => $nQId,
            'prevqId' => $pQId,
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
    {

    }

    /**
     * Update all elements passed in from the web form.
     * Has 3 possible routes: back to EditQuestion, forward to EditRoster or to editElements (new question)
     *
     * @param Exam $exam
     * @param Question $question
     * @param ElementRequest $request
     * @return Response
     */
    public function updateAll($exam, $question, ElementRequest $request)
    {

        $examId = $exam->getId();
        $questionId = $question->getId();
        $numValences = count( Comment::$valences );
        //  Update elements and create new elements as necessary
        $currentElements = [];
        $i = 1;
        while ($request->input('elementName' . $i)) {
            $elementId = $request->input('elementId' . $i);
            // New elements arrive with id == 0
            // We're not using the 'displayText' parameter at this time.
            if ($elementId == 0) {
                // Add new Elements
                $element = $this->elementDao->createElement( $request->input('elementName' . $i), '' ,
                        $request->input('elementText' . $i));
                $this->assignmentDao->record($examId, $questionId, $element->getId(), $i);
            } else {
                // Update existing
                $element = $this->elementDao->editElement($elementId, $request->input('elementName' . $i), '',
                        $request->input('elementText' . $i));
                $this->assignmentDao->record($examId, $questionId, $elementId, $i);
            }
            // Loop through valences and add / edit comments
            for($j = 0; $j < $numValences; $j++) {

                $this->elementDao->addValencedContent($element->getId(), $j, $request->input('e'.$i.'valence'.$j));
            }
            $currentElements[$element->getId()] = $element;
            $i++;
        }
        // Handle item deletion

        // NOTE: any elements associated with this exam that weren't submitted with the form are deleted.
        // This can be hard on the test data as it contains multiple re-uses of the same elements (bb 8/2/15).

        $questionNumber = $question->getQuestionNumber($examId);
        $oldElements = $this->assignmentDao->load_elements($examId, $questionNumber );
        if ( count($oldElements) > 0) {
            foreach ($oldElements as $oldElement) {
                $eIdToFind = $oldElement->getId();
                if (!array_key_exists($eIdToFind, $currentElements)) {
                    // are deletions removing elements? or just assignments?
                    $this->elementDao->deleteElement($eIdToFind);
                    dd($eIdToFind);
                }
            }
        }

        /* Choose next action based on 'questionDirection' param:
            1. go back to QuestionController
            2. go forward to StudentController
            3. load another question for element editing
        */
        $nextAction = $request->input('questionDirection');
        if ($nextAction === 'back') {
            return redirect()->route('editAllQuestions', $examId);
        } else if ($nextAction === 'forward') {
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
