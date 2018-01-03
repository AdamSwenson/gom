<?php

namespace App\Http\Controllers\Feedback;

use App\Assignment;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;

class FeedbackPreviewController extends Controller
{


    /**
     * Returns the data for student feedback preview
     *
     * @param Exam $exam
     * @param Student $student
     * @return void
     */
    public function show(Exam $exam , Student $student)
    {
        $out = $this->assignmentRepository->getItemOrderForClient($exam);
        //The returned array  will have the keys
        //  'itemObjects'
        //  'itemOrder'
        $kumis = $exam->kumis()->get();

        if($kumis->count() === 0){
            //if there isn't one, we need it
            $kumi = Kumi::create();
            $exam->kumis()->attach($kumi->id);
            $kumis = $exam->kumis()->get();
        }

        //So we add some additional elements that the page expects
        $standard = [
            'examObjectJsonName' => self::EXAM_JSON_NAME,
            'itemObjectJsonName' => self::ITEM_OBJECT_JSON_NAME,
            'itemOrderJsonName' => self::ITEM_ORDER_JSON_NAME,
            'kumisJsonName' => self::KUMIS_JSON_NAME,
            'exam' => $exam,
            'kumis' => $kumis];

        $out += $standard;



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
