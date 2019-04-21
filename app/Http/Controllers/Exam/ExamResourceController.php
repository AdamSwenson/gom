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

    public $updatable = [
        'customMaxScore',
        'description',
        'family',
        'name',
        'publicName',
        'term',
        'year'
    ];


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Some fields should be reset to null if the existing value
     * is deleted on the client. However, the incoming
     * request will have an empty string. This casts
     * such strings to null
     *
     * @param $incoming
     * @return |null
     */
    public function castEmptyToNull( $incoming )
    {
        return empty($incoming) ? null : $incoming;
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        //
    }

    /**
     * Display the specified resource.
     * This seems weird but the route will
     * include the exam's id, thus this is the way
     * we get the full object from the server
     * @param  \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function show( Exam $exam )
    {
        return $exam;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function edit( Exam $exam )
    {
        //
    }

    /**
     * Update the specified exam in storage.
     * Receives PUT
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Exam $exam )
    {

        $this->handleUpdate($request, $exam);

        return $exam;

//
//        //update its properties
//        $exam->update(
//            [
//                'custom_max_score' => $this->castEmptyToNull($request->input('customMaxScore')),
//                'description' => $request->input('description'),
//                'family' => $request->input('family'),
//                'name' => $request->input('name'),
//                'public_name' => $request->input('publicName'),
//                'term' => $request->input('term'),
//                'year' => $request->input('year'),
//            ]);

        //return $this->itemRepository->handleStoreAndUpdate($request);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy( Exam $exam )
    {
        //
    }

    /**
     * Utility function for making changes
     * to the Exam object's properties
     *
     * @param Request $request
     * @param Exam $exam
     */
    public function handleUpdate( Request $request, Exam $exam)
    {
        $toUpdate = [];

        foreach ( $this->updatable as $f ) {
            //We can't use $request->has($f) to check if the field is included
            //since it returns false on an empty string.
            //We would not update the field in the db.
            //Thus, we need to manually reset the empty string to null
            //so that we don't have empty strings laying around,
            //screwing up tests for whether the value is set.
            $toUpdate[snake_case($f)] = $this->castEmptyToNull($request->input($f));
        }

        $exam->update($toUpdate);

        return $exam;
    }
}
