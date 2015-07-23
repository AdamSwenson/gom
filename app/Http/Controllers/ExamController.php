<?php

namespace App\Http\Controllers;


use App\classes\ExamClasses\display\PublicNameFormatter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*
    ExamController routes requests to appropriate page of the create exam workflow
*/

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index() {
        $exams = ['1', '2'];
        return view('/setup/select_exam')->with('exams', $exams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        //create new exam

        $examid = "New Exam";
        return view('setup/create_exam')->with(['examid'=>$examid]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
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
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request)
    {
        // do something to get id from DB
       // $exam = \ExamQuery::create()->findById($id);
        $exam = [];
        $examid = $request->get('examid');
        return view('setup/edit_exam', compact('exam'))->with(['examid' => $examid]);
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
        return ('you have successfully destroyed '.$id.'. Good work.');
    }

}
