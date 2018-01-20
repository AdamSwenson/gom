<?php

namespace App\Http\Controllers\Exam;

use App\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class ExamResourceController
 *
 * This is the new controller for restful
 * exam operations
 * @package App\Http\Controllers
 */
class ExamResourceController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Return all of the user's exams
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //todo add connection to item
        return Exam::all();
        //todo make sure limited by base model
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Create a new exam
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * This seems weird but the route will
     * include the exam's id, thus this is the way
     * we get the full object from the server
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        return $exam;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified exam in storage.
     * Receives PUT
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
$updatable = ['name', 'publicName', 'term', 'year'];

        //update its properties
        $exam->update(
            [
                'description' => $request->input('description'),
                'family' => $request->input('family'),
                'name' => $request->input('name'),
                'public_name' => $request->input('publicName'),
                'term' => $request->input('term'),
                'year' => $request->input('year'),
            ]);
        return $exam;

        //return $this->itemRepository->handleStoreAndUpdate($request);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        //
    }
}
