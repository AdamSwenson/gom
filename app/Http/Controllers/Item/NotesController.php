<?php

namespace App\Http\Controllers\Item;

use App\Exam;
use App\Http\Requests\NoteRequest;
use App\Item;
use App\Models\NewGom\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Note::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Item $item
     * @param NoteRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Item $item, NoteRequest $request )
    {
        $note = Note::create($request->all());
        $note->save();
        $item->save();
        $item->notes()->attach($note->id);
        $item->save();
        return $note;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show(  $id )
    {
        return Note::find($id);

    //    return $note;
    }

    public function showForExam(Exam $exam)
    {
        return $exam->notes;
    }

    public function showForItem(Item $item)
    {
        return $item->notes;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param Note $note
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update( Note $note, Request $request )
    {
        $note->update([
            'text' => $request->input('text'),
            'name' => $request->input('name'),
            'priority' => $request->input('priority'),
            'props' => $request->input('props')
        ]);

        $this->sendAjaxSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Note::destroy($id);
        $this->sendAjaxSuccess();
    }
}
/**
 *
 * /**
 * Show the form for creating a new resource.
 * // *
 * // * @return \Illuminate\Http\Response
 * // */
//public function create()
//{
//    //
//}
// */

///**
// * Show the form for editing the specified resource.
// *
// * @param  int  $id
// * @return \Illuminate\Http\Response
// */
//public function edit($id)
//{
//    //
//}
