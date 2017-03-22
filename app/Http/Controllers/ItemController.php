<?php

namespace App\Http\Controllers;

use App\Element;
use App\Exam;
use App\Http\Requests\ItemRequest;
use App\Question;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public $type;
    public $exam;

// ---------------------------------- Helpers
    /**
     * Sets the $type value from the request
     * @param ItemRequest $request
     */
    protected function determineItemType(ItemRequest $request)
    {
        //The request will be coming in with potentially a few
        //of the item fields filled in. However, we are only concerned with
        //figuring out what kind of item is being requested and its relationships,
        //and then creating those and returning the relevant ids so that
        //they can be set on the client
        switch ($request) {
            case $this->isExam($request):
                //Set the type as exam
                $this->type = Exam::class;
                break;
            case $this->isQuestion($request):
                $this->type = Question::class;
                break;
            case $this->isElement($request):
                $this->type = Element::class;
                break;
            default:
                //todo add error case
        }

    }

    /**
     * Returns true if the request concerns an element,
     * returns false otherwise
     * @param ItemRequest $request
     * @return bool
     */
    protected function isElement(ItemRequest $request)
    {
        //If it wasn't an exam, it was either a question or element
        //We figure this out from the depth
        if ($request->input('depth') > 0) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if the request concerns an exam,
     * returns false otherwise
     * @param ItemRequest $request
     * @return bool
     */
    protected function isExam(ItemRequest $request)
    {
        //Exams are the root element with an index of 0 and a depth of 0
        if ($request->input('index') == 0 && $request->input('depth') == 0) {
            return true;
        }
        return false;
    }


    /**
     * Returns true if the request concerns a question,
     * returns false otherwise
     * @param ItemRequest $request
     * @return bool
     */
    protected function isQuestion(ItemRequest $request)
    {
        //If it wasn't an exam, it was either a question or element
        //We figure this out from the depth
        if ($request->input('index') > 0 && $request->input('depth') == 0) {
            return true;
        }
        return false;
    }


// -------------------------------- Controller methods


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('development.newsetup');
    }

    /**
     * the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * That is, create new Exam, Question, or Element depending on the
     * index and depth, associating them with an exam as
     * in the usual models
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        //The request will be coming in with potentially a few
        //of the item fields filled in. However, we are only concerned with
        //figuring out what kind of item is being requested and its relationships,
        //and then creating those and returning the relevant ids so that
        //they can be set on the client
        $this->determineItemType($request);

        switch ($this->type) {
            case Exam::class:
                return new Exam();
                //todo eventually should redirect and use common action or job
//                return redirect()->action('ExamController@store');
                break;

            case Element::class:
                //todo eventually should redirect and use common action or job
                //make new element
                return new Element();
                break;
            case Question::class;
                //make new question
                //todo eventually should redirect and use common action or job
                return new Question();
                break;
            default:
                //todo add error
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ItemRequest $request)
    {
        $this->determineItemType($request);

        switch ($this->type) {
            case Exam::class:
                break;

            case Element::class:
                //make new element
                break;
            case Question::class;
                //make new question
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemRequest $request)
    {
        $this->determineItemType($request);

        switch ($this->type) {
            case Exam::class:
                break;

            case Element::class:
                //make new element
                break;
            case Question::class;
                //make new question
                break;
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->determineItemType($request);

        switch ($this->type) {
            case Exam::class:

                break;

            case Element::class:
                //make new element
                break;

            case Question::class;
                //make new question
                break;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemRequest $request)
    {
        $this->determineItemType($request);

        switch ($this->type) {
            case Exam::class:
                break;

            case Element::class:
                //make new element
                break;

            case Question::class;
                //make new question
                break;
        }
    }
}
