<?php

namespace App\Http\Controllers\Analytics;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Models\NewGom\ItemScore;
use Illuminate\Http\Request;

class TotalScoreController extends Controller
{

    /**
     * Returns just the total score for each student on the exam
     * Does not return any identifiable information about
     * who which score belongs to
     *
     * @param Exam $exam
     * @return array
     */
    public function getTotalScoresForExam( Exam $exam )
    {

        $scores = [];

        $byStudent = collect(ItemScore::where('exam_id', $exam->id)->get())->groupBy('student_id');

        foreach ( $byStudent as $s) {
            $scores[] = $s->sum('score'); //->getTotalScoreOnExam($exam);
        }

        //sort the scores before returning
        $sorted = collect($scores)->sort();

        return ['totalScores' => $sorted];
    }

}
