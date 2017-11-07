<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/27/17
 * Time: 6:43 PM
 */

namespace App\Repositories\Item;

use App\Exam;
use App\Item;

interface IItemScoreStatisticsRepository
{

    /**
     * Returns the mean, standard deviation, max, min, and n
     *
     * @param Item|null $item
     * @param Exam|null $exam
     * @return \Illuminate\Support\Collection
     */
    public function getDescriptiveStats( Item $item, Exam $exam = null);

    /**
     * Find the median for the item scores
     * @param Item $item
     * @param Exam|null $exam
     * @return float
     */
    public function getMedian( Item $item, Exam $exam = null);

    /**
     * Calculates the 25th and 75th percentiles for element scores
     * @param Item $item
     * @param Exam|null $exam
     * @return array Keys quartile1 and quartile3
     */
    public function getQuartiles( Item $item, Exam $exam = null);

    public function make_where_clause( Exam $exam = null, Kumi $kumi = null );

    /**
     * Returns the values array to use with the
     * where clause. We do not like SQL injection
     * so we do it this way.
     * @param Item $item
     * @param Exam $exam
     * @param Kumi $kumi
     * @param $student
     * @return array
     */
    public function make_values_array( Item $item = null, Exam $exam = null, Kumi $kumi = null, $student = null );

    /**
     * Returns the mean, standard deviation, max, min, and n
     *
     * @param Item|null $item
     * @param Exam|null $exam
     * @param Kumi|null $kumi
     * @return \Illuminate\Support\Collection
     */
    public function getDescriptiveStatsForKumi( Item $item, Kumi $kumi );

}