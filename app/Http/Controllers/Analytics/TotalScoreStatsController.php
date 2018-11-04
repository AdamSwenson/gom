<?php

namespace App\Http\Controllers\Analytics;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Models\NewGom\ItemScore;
use App\Repositories\Score\ITotalScoreRepository;
use Illuminate\Http\Request;

/**
 * Returns statistical summary data about the
 * total scores for the exam
 *
 * Class TotalScoreStatsController
 * @package App\Http\Controllers\Analytics
 */
class TotalScoreStatsController extends Controller
{
    /**
     * @var ITotalScoreRepository
     */
    public $totalScoreRepository;

    public function __construct( ITotalScoreRepository $totalScoreRepository)
    {
        $this->totalScoreRepository = $totalScoreRepository;
    }

    /**
     * Returns the summary statistics for the
     * total scores on the exam
     * @param Exam $exam
     * @return array
     */
    public function show( Exam $exam )
    {
        $scores = $this->totalScoreRepository->getTotalScoresForExam($exam);
        $out = [];
        $out['mean'] = $scores->average();
        $out['median'] = $scores->median();
        $out['min'] = $scores->min();
        $out['max'] = $scores->max();
        $out['count'] = $scores->count();

        return $out;

//        $byStudent = collect(ItemScore::where('exam_id', $exam->id)->get())->groupBy('student_id');
//
//        foreach ( $byStudent as $s) {
//            $scores[] = $s->sum('score'); //->getTotalScoreOnExam($exam);
//        }

        //sort the scores
//        $scores = collect($scores)->sort();

    }

}
