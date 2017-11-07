<?php

namespace App\Http\Controllers\Item;

use App\Exam;
use App\Item;
use App\Kumi;
use App\Repositories\Item\IItemScoreStatisticsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * This is used for information about item scores
 * without including student information
 *
 *
 * Class ItemStatsController
 * @package App\Http\Controllers\Item
 */
class ItemStatsController extends Controller
{

    public $student;
    public $exam;
    public $item;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Returns the scores for this item,
     * regardless of the exam without student data
     * @param Item $item
     * @return array
     */
    public function itemScores( Item $item )
    {
        $out = [];
        $scores = $item->scores;
        foreach ( $scores as $score ) {

            $out[] = [
                'examId' => $score->exam_id,
                'itemId' => $item->id,
                'score' => $score->score,
                'kumis' => $score->student->kumis
            ];
        }
        return $out;
    }


    /**
     * Returns the scores for all items on the exam
     * without student data
     * @param Exam $exam
     * @return array
     */
    public function examScores( Exam $exam )
    {
        $out = [];
        $items = $exam->getItems();
        foreach ( $items as $item ) {
            $scores = $item->scores;

            foreach ( $scores as $score ) {

                $out[] = [
                    'examId' => $score->exam_id,
                    'itemId' => $item->id,
                    'score' => $score->score,
                    'kumis' => $score->student->kumis
                ];
            }
        }

        return $out;
    }

    /**
     * Will return collection for all item scores with keys
     *      mean,
     *      standardDeviation,
     *      maxScore,
     *      minScore,
     *      numberAnswers
     * @param Item $item
     * @return \Illuminate\Support\Collection
     */
    public function itemSummary( Item $item )
    {
        $repo = app()->make(IItemScoreStatisticsRepository::class);

        $result = $repo->getDescriptiveStats($item);

        //Add the median to the result
        $result['median'] = $repo->getMedian($item);

        //Add the quartiles
        $quartiles = $repo->getQuartiles($item);
        $result['percentile25'] = $quartiles['quartile1'];
        $result['percentile75'] = $quartiles['quartile3'];

        //Make the summary array into a laravel collection
        $result = collect($result);
        return $result;
//        return $repo->getSummaryStatsForItem($item);
    }


    /**
     * Will return collection for item scores on the exam with keys
     *      mean,
     *      standardDeviation,
     *      maxScore,
     *      minScore,
     *      numberAnswers
     * @param Exam $exam
     * @param Item $item
     * @return \Illuminate\Support\Collection
     */
    public function itemSummaryForExam( Exam $exam, Item $item )
    {
        $repo = app()->make(IItemScoreStatisticsRepository::class);

        $result = $repo->getDescriptiveStats($item, $exam);

        //Add the median to the result
        $result['median'] = $repo->getMedian($item, $exam);

        //Add the quartiles
        $quartiles = $repo->getQuartiles($item, $exam);
        $result['percentile25'] = $quartiles['quartile1'];
        $result['percentile75'] = $quartiles['quartile3'];

        //Make the summary array into a laravel collection
        $result = collect($result);
        return $result;
    }


    public function itemSummaryByKumi( Item $item )
    {
//        dd($item->kumis);
//        $kumis = [];
//        foreach($item->scores as $score){
//             $kumis[] = $score->kumis;
//         }
//         dd($kumis);

        $repo = app()->make(IItemScoreStatisticsRepository::class);
        return $repo->getDescriptiveStatsByKumiForItem($item);
    }

}
