<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ElementController extends Controller
{
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
    public function edit($exam, $question)
    {
        $data['examId'] = $exam;
        $data['qId'] = $question;

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

    /**
     * Saves the elements for the question and redirects to StudentController
     */
    public function done() {
        return ('this connects to the edit students page');
    }
}
