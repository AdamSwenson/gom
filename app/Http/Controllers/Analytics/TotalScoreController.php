<?php

namespace App\Http\Controllers\Analytics;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Models\NewGom\ItemScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
        $query = <<<MYSQL
        SELECT SUM(s.score) AS totalScore FROM item_scores s
        INNER JOIN items i ON s.item_id = i.id
        WHERE s.exam_id = :examId AND i.counts_in_total = 1
        GROUP BY s.student_id;
MYSQL;

        $result = DB::select($query, ['examId' => $exam->id]);
//        $scores = $result[0]->totalScores;

        $scores = [];
        foreach($result as $r){
            $scores[] = $r->totalScore;
        }

//        $byStudent = collect(ItemScore::where('exam_id', $exam->id)->get())->groupBy('student_id');
//
//        foreach ( $byStudent as $s) {
//            $scores[] = $s->sum('score'); //->getTotalScoreOnExam($exam);
//        }

        //sort the scores before returning
        $sorted = collect($scores)->sort();

        return ['totalScores' => $sorted];
    }

}
