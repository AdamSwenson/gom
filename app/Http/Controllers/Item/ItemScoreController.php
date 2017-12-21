<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemScoreRequest;
use App\Item;
use App\Exam;
use App\Student;
use App\Models\NewGom\ItemScore;
use Illuminate\Http\Request;

/**
 * This is used for item score information
 * where identifying student data is included
 *
 * ANY REQUEST FOR SCORES WHICH DOES NOT NEED STUDENT
 * DATA SHOULD BE HANDLED BY THE ITEM STATS CONTROLLER.
 *
 */
class ItemScoreController extends Controller
{

    public $student;
    public $exam;
    public $item;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function loadIdentifiers( ItemScoreRequest $request )
    {
        $this->exam = Exam::find($request->examId);
        $this->item = Item::find($request->itemId);
        $this->student = Student::find($request->studentId);
//todo add error handling here so this kills it if there's a missing value
    }


    public function saveScore( Exam $exam, Item $item, Student $student, Request $request )
    {
        $score = ItemScore::where('exam_id', $exam->id)
            ->where('item_id', $item->id)
            ->where('student_id', $student->id)
            ->first();

        if ( !isset($score) ) {
            //doing this explicitly since
            //there's some problem when try the
            //eloquent way
            $score = new ItemScore();
            $score->exam_id = $exam->id;
            $score->item_id = $item->id;
            $score->student_id = $student->id;
        }

        //Now, whether old or new, we set the data
        //properties
        //The score and comment come in separately
        //from different requests. So, we need to be careful
        //not to inadvertently overwrite the score on a comment request
        //or vice-versa.
        if ( $request->has('score') ) {
            $score->score = $request->input('score');
        }
        if ( $request->has('commentText') ) {
            $score->comment_text = $request->input('commentText');
        }

        //and finally save
        $score->save();

        return $this->sendAjaxSuccess();
    }


    /**
     * Create a new store object or update an existing one
     * @param ItemScoreRequest $request
     * @return ItemScore
     */
    public function store( ItemScoreRequest $request )
    {
        $this->loadIdentifiers($request);
        //if no exception, we assume everything is set
        $score = ItemScore::where('exam_id', $this->exam->id)
            ->where('student_id', $this->student->id)
            ->where('item_id', $this->item->id)
            ->first();

        if ( !isset($score) ) {
            //doing this explicitly since
            //there's some problem when try the
            //eloquent way
            $score = new ItemScore();
            $score->exam_id = $this->exam->id;
            $score->item_id = $this->item->id;
            $score->student_id = $this->student->id;
        }

        //Now, whether old or new, we set the data
        //properties
        $score->score = $request->input('score');
        $score->comment_text = $request->input('commentText');
        //and finally save
        $score->save();

        return $score;

    }

    /**
     * Gets all scores for an item, regardless of which exam the item
     * was used on.
     *
     * Route:
     *          GET
     *          dev/scores/item/{item}'
     *
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function itemScores( Item $item )
    {
        return ItemScore::where('item_id', $item->id)->get();
    }

    /**
     * Get all item scores for all items and all students on the exam
     *
     * @param Exam $exam
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function examScores( Exam $exam )
    {
        return ItemScore::where('exam_id', $exam->id)->get();
    }

    /**
     * Gets all scores for the student, regardless of exam or
     * item.
     *
     * @param Student $student
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function studentScores( Student $student )
    {
        return ItemScore::where('student_id', $student->id)->get();
    }


}
