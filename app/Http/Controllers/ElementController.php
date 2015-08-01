<?php

namespace App\Http\Controllers;

use App\Element;
use App\Http\Requests\ElementRequest;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
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
    public function __construct(IElementRepository $elementDao, IElementAssignmentRepository $assignmentDao)
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
    public function editAll() {
        $exam = 1;
        $question = 1;
        $nextqId = 2;
        $prevqId = 0;
        // shows all elements for a given question
        return view('setup.edit_element')->with( ['examId' => $exam,
            'qId' => $question,
            'nextqId' => $nextqId,
            'prevqId' => $prevqId]);
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
