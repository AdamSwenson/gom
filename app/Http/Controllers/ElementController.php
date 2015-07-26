<?php

namespace App\Http\Controllers;

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
     * @param  $question
     * @return Response
     */
    public function index($question)
    {
        return ('List of elements for question id: '.$question);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $exam
     * @return Response
     */
    public function edit($exam)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $exam
     * @return Response
     */
    public function update($exam)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
