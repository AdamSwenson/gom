<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('setup/edit_question');
    }

    /**
     * Show the form for creating a new resource.
     * @param id
     * @return Response
     */
    public function create($exam)
    {

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
        // default data for dev purposes
        $q1 = [ 'qName' => 'teat name #1',
            'qDesc' => 'description 1 here',
            'qOrder' => 1];

        $q2 = [ 'qName' => 'test name #2',
            'qDesc' => 'description 2 here',
            'qOrder' => 2];


        $questions = [ '0' => $q1,
            '1' => $q2 ];

        $examName = 'History 101 Exam 1, Fall 2015';

        //return view('/setup/edit_question');
        return view('setup.edit_question')->with('questions', $questions)->with('examName', $examName);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
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
