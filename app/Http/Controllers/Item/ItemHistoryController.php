<?php

namespace App\Http\Controllers\Item;

use App\Assignment;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;

class ItemHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        //
    }

    /**
     * Return the exams on which the item has
     * been used
     *
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function show( Item $item )
    {
        $out = [];
        $assignments = Assignment::where('item_id', $item->id)->get();
        foreach ( $assignments as $assignment ) {
            $out[] = $assignment->exam;
        }

        return $out;;

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
