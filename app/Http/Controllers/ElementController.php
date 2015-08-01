<?php

namespace App\Http\Controllers;

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
     */
    public function __construct(IElementRepository $elementDao,
        IElementAssignmentRepository $assignmentDao,
        IQuestionAssignmentRepository $questionAssignmentRepo)
    {
        $this->elementDao = $elementDao;
        $this->assignmentDao = $assignmentDao;
    }

    /**
     * Display a listing of the resource.
     * @param ElementRequest $request
     * @return Response
     */
    public function index(ElementRequest $request)
    {
        if(!empty($questionId))
        {}
        else{
            return Element::all();
        }
        $element = $this->dao->loadElementById($elementId);
        return $element;
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

        if(!empty($element))
        {
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
     * @param  int  $id
     * @return Response
     */
    public function show(Element $element)
    {
        $element = $this->dao->loadElementById($elementId);
        return $element;


        //
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
     *
     */
    public function editAll($exam, $question)
    {
        // element->comments  <- gets a collection of comments to work on

        // given the current $question, find previous and next
        $qId = $question->getId();
        $examId = $exam->getId();

        $allQuestionAss = $this->questionAssignmentDAO->load_all_for_exam($examId);
        // loadByIds() will loop if the same questionId appears several times on the same exam,
        // as it matches with the first Id found in the ordered Assignments.
        $qNumber = $this->questionAssignmentDAO->loadByIds($examId, $qId);
        $index = 0;
        // .. look through it to find the index that our question appears

        foreach ($allQuestionAss as $questionAss) {
              if ($qId === $questionAss->question_id) {

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
        $elements = [];

        /*
        $assignments = $this->assignmentDao->load_element_assignments_by_question_number($examId, $qNumber);
        $numValences = sizeof(Comment::$valences);
        $counter = 0;
        foreach ($assignments as $ass) {
            $elementId = $ass->element_id;
            $elements['eObj'] = this->elementDao->loadElementById($elementId);
            $valences['eValence'] =

        }
        $elements[$counter++] = $q;
        }
        */

        // shows all elements for a given question along with the ids for 'next' and 'previous'
        return view('setup.edit_element')->with(['examId' => $examId,
            'qId' => $qId,
            'nextqId' => $nQId,
            'prevqId' => $pQId,
            'questionName' => $question->getQuestionName(),
            'qNumber' => $qNumber,
            'questions' => $elements]);
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
     * Remove the specified resource from storage.
     *
     * @param Element $element
     * @return Response
     * @internal param int $id
     */
    public function destroy(Element $element)
    {
        //
    }

    /**
     * Saves the elements for the question and redirects to StudentController
     */
    public function done() {
        return ('this connects to the edit students page');
        return $this->elementDao->deleteElement($element);
    }
}
