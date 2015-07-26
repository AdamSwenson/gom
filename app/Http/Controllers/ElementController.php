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
        //for question number
        return $this->dao->load_element_assignments_by_question_number($examId, $questionNumber);
        return ('List of elements for question id: '.$question);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(ElementRequest $request)
    {
        //
        $element = $this->dao->createElement($elementName, '', $respGeneric);
        if(!empty($element))
        {
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_ABSENT, $respAbsent);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_POOR, $respPoor);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_OK, $respFair);
            $this->dao->addValencedContent($element->getId(), Comment::VALENCE_EXCELLENT, $respGood);

            $this->assignmentDao->record($examId, $questionNumber, $element->getId(), $subtask);
        }
        return $element;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ElementRequest $request)
    {
        //
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
     * @param  int  $id
     * @return Response
     */
    public function destroy(Element $element)
    {
        return $this->elementDao->deleteElement($elementId);
        //
    }
}
