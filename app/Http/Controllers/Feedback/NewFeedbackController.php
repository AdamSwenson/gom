<?php

namespace App\Http\Controllers\Feedback;

use App\Assignment;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Models\NewGom\ItemScore;
use App\Repositories\Assignment\IAssignmentRepository;
use App\Student;
use Illuminate\Http\Request;

class NewFeedbackController extends Controller
{

    const EXAM_JSON_NAME = 'loadedExam';
    const ITEM_ORDER_JSON_NAME = 'loadedItemOrder';
    const ITEM_OBJECT_JSON_NAME = 'loadedItemObjects';
    const KUMIS_JSON_NAME = 'loadedKumis';

    /**
     * Returns the data for student feedback preview
     *
     * @param Exam $exam
     * @param Student $student
     * @return void
     */
    public function show( Exam $exam, Student $student )
    {
        $assignmentDao = app()->make(IAssignmentRepository::class);
        $out = $assignmentDao->getItemOrderForClient($exam);
        //The returned array  will have the keys
        //  'itemObjects'
        //  'itemOrder'
        $kumis = $exam->kumis()->get();

        if ( $kumis->count() === 0 ) {
            //if there isn't one, we need it
            $kumi = Kumi::create();
            $exam->kumis()->attach($kumi->id);
            $kumis = $exam->kumis()->get();
        }
        $scores = ItemScore::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->get();

        //So we add some additional elements that the page expects
        $standard = [
            'exam' => $exam,
            'student' => $student,
        'scores' => $scores
        ];

        $out += $standard;

        return view('development.newfeedback', $out);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        //
    }
}
