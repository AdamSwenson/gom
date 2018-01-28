<?php

namespace App\Http\Controllers\Roster;

use App\Exam;
use App\Http\Requests\KumiRequest;
use App\Kumi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KumiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Kumi::all();
    }


    /**
     * Store a newly created kumi in storage.
     *
     * Client:
     *      kumiRequests.createKumi
     *
     * Route:
     *      POST
     *
     * @param KumiRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(KumiRequest $request)
    {
        $kumi = Kumi::create([
            'name' => $request->input('name'),
            'year' => $request->input('year'),
            'description' => $request->input('description')
        ]);
        if($request->has('examId')){
            $exam = Exam::find($request->input('examId'));
            $exam->kumis()->attach($kumi->id);
        }
        return $kumi;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Kumi::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * Client:
     *      kumiRequests.updateKumi
     *
     * Route:
     *      PUT
     *
     * @param Kumi $kumi
     * @param KumiRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Kumi $kumi, KumiRequest $request)
    {
        $kumi->update([
            'name' => $request->input('name'),
            'year' => $request->input('year'),
            'description' => $request->input('description')
        ]);
        $kumi->save();

        $this->sendAjaxSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Kumi $kumi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kumi $kumi)
    {
        $kumi->delete();
        $this->sendAjaxSuccess();
    }

    /**
     * Attaches a kumi to an exam
     *  Route:
     *          dev/kumi/exam/{exam}/new
     *
     * @param Exam $exam
     * @param Kumi $kumi
     * @return mixed
     */
    public function associateExamAndKumi(Exam $exam, Kumi $kumi){
        $exam->kumis()->attach($kumi->id);
        return $this->sendAjaxSuccess();
    }

    /**
     * Detaches a kumi from an exam
     *  Route:
     *          dev/kumi/exam/{exam}/new
     *
     * @param Exam $exam
     * @param Kumi $kumi
     * @return mixed
     */
    public function disassociateExamAndKumi( Kumi $kumi, Exam $exam){
        $exam->kumis()->detach($kumi->id);
        return $this->sendAjaxSuccess();
    }

    /**
     *  Route:
     *          dev/kumi/exam/{exam}
     *
     * @param Exam $exam
     * @return mixed
     */
    public function loadExamKumi(Exam $exam){
        $kumis = $exam->kumis()->get();
        //should this redirect to createExamKumi?
        return $kumis;
    }

}
