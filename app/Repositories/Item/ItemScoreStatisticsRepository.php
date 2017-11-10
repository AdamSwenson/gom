<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/27/17
 * Time: 4:10 PM
 */

namespace App\Repositories\Item;


use App\Exam;
use App\Item;
use Illuminate\Support\Facades\DB;

class ItemScoreStatisticsRepository implements IItemScoreStatisticsRepository
{
    public static $descriptiveStatKeys = ['mean', 'maxScore', 'minScore', 'numberAnswers', 'standardDeviation'];


    //from http://stackoverflow.com/questions/1291152/simple-way-to-calculate-median-with-mysql
    const MEDIAN_ALL_QUERY = <<<MYSQL
        SELECT AVG(t1.score) AS score 
        FROM (
                SELECT @rownum:=@rownum+1 AS `row_number`, score
                FROM item_scores,  (SELECT @rownum:=0) r
                WHERE item_id = :itemId
                ORDER BY score
        ) AS t1,
        (
            SELECT count(*) AS total_rows
            FROM item_scores d
            WHERE item_id = :itemId2 
             ) AS t2
        WHERE 1
        AND t1.row_number IN ( floor((total_rows+1)/2), floor((total_rows+2)/2) )
MYSQL;

    const MEDIAN_W_EXAM_QUERY = <<<MYSQL
        SELECT AVG(t1.score) AS score 
        FROM (
                SELECT @rownum:=@rownum+1 AS `row_number`, score
                FROM item_scores,  (SELECT @rownum:=0) r
                WHERE item_id = :itemId AND exam_id = :examId
                ORDER BY score
        ) AS t1,
        (
            SELECT count(*) AS total_rows
            FROM item_scores d
            WHERE item_id = :itemId2 AND exam_id = :examId2
        ) AS t2
        WHERE 1
        AND t1.row_number IN ( floor((total_rows+1)/2), floor((total_rows+2)/2) )
MYSQL;

    const MEDIAN_BY_KUMI_QUERY = <<<MYSQL
        SELECT AVG(t1.score) AS score 
        FROM (
                SELECT @rownum:=@rownum+1 AS `row_number`, score
                FROM item_scores i,  (SELECT @rownum:=0) r
                INNER JOIN kumi_student k ON i.student_id = k.student_id 
                WHERE i.item_id = :itemId AND k.kumi_id = :kumiId
                ORDER BY score
        ) AS t1,
        (
            SELECT count(*) AS total_rows
            FROM item_scores i2
              INNER JOIN kumi_student k2 ON i2.student_id = k2.student_id 
                WHERE i2.item_id = :itemId2 AND k2.kumi_id = :kumiId2
           ) AS t2
        WHERE 1 AND t1.row_number IN ( floor((total_rows+1)/2), floor((total_rows+2)/2) )
        
MYSQL;

    const DESCRIPTIVE_BY_KUMI = <<<MYSQL
  SELECT 
             AVG(score) AS mean, 
             STD(score) AS standardDeviation, 
             MAX(score) AS maxScore, 
             MIN(score) AS minScore, 
             COUNT(score) AS numberAnswers 
         FROM item_scores i
         INNER JOIN kumi_student k ON i.student_id = k.student_id 
         WHERE i.item_id = :itemId AND k.kumi_id = :kumiId;
MYSQL;

    const ITEM_SCORES_FOR_KUMI = <<<MYSQL
              SELECT i.item_id, i.score, i.exam_id, k.kumi_id 
              FROM item_scores i
              INNER JOIN kumi_student k ON i.student_id = k.student_id 
              WHERE i.item_id = :itemId AND k.kumi_id = :kumiId;
MYSQL;


    /**
     * Will return collection of stats for item scores with keys
     *      mean,
     *      median,
     *      standardDeviation,
     *      maxScore,
     *      minScore,
     *      numberAnswers
     *
     * The quartiles need to be added independently if they are desired.
     *
     * If only the item is provided, it returns these for all scores.
     *
     * If the exam is provided, it returns these only for item scores on the
     * exam
     *
     * @param Item|null $item
     * @param Exam|null $exam
     * @return \Illuminate\Support\Collection
     */
    public function getDescriptiveStats( Item $item, Exam $exam = null )
    {
        $query = <<<MYSQL
         SELECT 
             AVG(score) AS mean, 
             STD(score) AS standardDeviation, 
             MAX(score) AS maxScore, 
             MIN(score) AS minScore, 
             COUNT(score) AS numberAnswers 
         FROM item_scores 
         WHERE item_id = :itemId
MYSQL;

        //Run the main query
        $values = ['itemId' => $item->id]; //$this->make_values_array($item, $exam, $kumi);

        //if exam is set, restrict the range of scores
        if ( !is_null($exam) ) {
            $query .= " AND exam_id = :examId";
            $values['examId'] = $exam->id;
        }

        $result = DB::select($query, $values);

        //Make the summary array into a laravel collection
        $result = collect($result[0]);

        //Add the median
        $result['median'] = $this->getMedian($item, $exam);

        return $result;
    }

    /**
     * Returns the mean, standard deviation, max, min, and n
     * for the item scores by kumis that the scores are associated with.
     * The median and quartiles must be obtained from different methods
     *
     *
     * @param Item|null $item
     * @param Kumi|null $kumi
     * @return \Illuminate\Support\Collection
     */
    public function getDescriptiveStatsForKumi( Item $item, Kumi $kumi )
    {
        $query = self::DESCRIPTIVE_BY_KUMI;

        //Run the main query
        $values = ['itemId' => $item->id, 'kumiId' => $kumi->id];
        $result = DB::select($query, $values);

        //Make the summary array into a laravel collection
        $result = collect($result[0]);
        return $result;
    }


    public function getItemScoresByKumi( $itemId, $kumiId )
    {
        $values = ['itemId' => $itemId, 'kumiId' => $kumiId];
        return collect(DB::select(self::ITEM_SCORES_FOR_KUMI, $values));
    }

    /**
     * @param Item $item
     * @return \Illuminate\Support\Collection
     */
    public function getDescriptiveStatsByKumiForItem( Item $item )
    {

        $query = <<<MYSQL
        SELECT
         k.id AS kumiId,
         k.name AS kumiName,
          AVG(score) AS mean,
          STD(score) AS standardDeviation,
          MAX(score) AS maxScore,
          MIN(score) AS minScore,
          COUNT(score) AS numberAnswers
         FROM item_scores i
         INNER JOIN kumi_student ks ON i.student_id = ks.student_id
         INNER JOIN kumis k ON ks.kumi_id = k.id
         WHERE i.item_id = :itemId
         GROUP BY ks.kumi_id
MYSQL;

        $values = ['itemId' => $item->id];
        $results = collect(DB::select($query, $values));

        //We now have a collection of results by kumi
        //to add things like the median for each kumi
        //we need to iterate through the collection and
        //add them manually
        foreach ( $results as $r ) {
            //It has been way too much of a pain in the ass to
            //write a fancy query that gets the median as well
            //in one shot. Since we want the scores anyway,
            //we load them and then use the collection method to calculate
            //the median and quartiles.
            $scores = $this->getItemScoresByKumi($item->id, $r->kumiId);
            $r->scores = $scores->sortBy('score');
            //compute the median from the scores
            $r->median = $scores->median('score');

            //Add quartiles here by counting the scores
            if($r->scores->count() >= 4 ){
                $cutoff25Index = ceil(0.25 * $r->scores->count());
                //todo should this be plus 1 since we want the next value? or will ceiling always get it?
                $cutoff75Index = ceil(0.75 * $r->scores->count());
                $r->percentile25 = $r->scores[$cutoff25Index];
                $r->percentile75 = $r->scores[$cutoff75Index];

            }
        }
        return collect($results);

    }


    /**
     * Find the median for the item scores using
     * a database query for speed
     *
     * @param Item $item
     * @param Exam|null $exam
     * @return float
     */
    public function getMedian( Item $item, Exam $exam = null )
    {
        $values = $this->make_values_array($item, $exam);

        $query = !is_null($exam) ? self::MEDIAN_W_EXAM_QUERY : self::MEDIAN_ALL_QUERY;

        $result = DB::select($query, $values);

        return $result[0]->score;
    }


    /**
     * Calculates the 25th and 75th percentiles for all item scores
     *
     * @param Item $item
     * @param Exam|null $exam
     * @return array Keys quartile1 and quartile3
     */
    public function getQuartiles( Item $item, Exam $exam = null )
    {

        $where_clause = $this->make_where_clause($exam);

//        SET @@group_concat_max_len := @@max_allowed_packet;
        //from http://rpbouman.blogspot.com/2008/07/calculating-nth-percentile-in-mysql.html
        $query = <<<MYSQL
        SELECT 
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(
            GROUP_CONCAT(score ORDER BY score SEPARATOR ','),
                ',', 25/100 * COUNT(*) + 1), ',', -1) AS DECIMAL) AS `quartile1`,
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(
            GROUP_CONCAT(score ORDER BY score SEPARATOR ','),
            ',', 75/100 * COUNT(*) + 1), ',', -1) AS DECIMAL) AS `quartile3`
        FROM item_scores
        WHERE item_id = :itemId 
        $where_clause
MYSQL;

        $values = ['itemId' => $item->id];
        //if exam was set, add id
        if ( !is_null($exam) ) $values['examId'] = $exam->id;
        $result = DB::select($query, $values);

        return [
            'quartile1' => $result[0]->quartile1,
            'quartile3' => $result[0]->quartile3
        ];
    }


    /**
     * Calculates the 25th and 75th percentiles for item scores for
     * each kumi associated with the item.
     * Returns a laravel collection of arrays each containing the kumi id,
     * item id, quartile1, and quartile3
     *
     * @todo Would be good if this were more flexible so could also do by exam or specific kumi with same method
     * @param Item $item
     * @return array Keys quartile1 and quartile3
     */
    public function getQuartilesForKumis( Item $item )
    {

//        SET @@group_concat_max_len := @@max_allowed_packet;
        //from http://rpbouman.blogspot.com/2008/07/calculating-nth-percentile-in-mysql.html
        $query = <<<MYSQL
        SELECT i.item_id AS itemId, 
        ks.id AS kumiId, 
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(
            GROUP_CONCAT(score ORDER BY score SEPARATOR ','),
                ',', 25/100 * COUNT(*) + 1), ',', -1) AS DECIMAL) AS `quartile1`,
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(
            GROUP_CONCAT(score ORDER BY score SEPARATOR ','),
            ',', 75/100 * COUNT(*) + 1), ',', -1) AS DECIMAL) AS `quartile3`
        FROM item_scores i
         INNER JOIN kumi_student k ON i.student_id = k.student_id 
         INNER JOIN kumis ks ON k.kumi_id = ks.id
         WHERE i.item_id = :itemId
         GROUP BY k.kumi_id;
MYSQL;

        $values = ['itemId' => $item->id];
        $result = DB::select($query, $values);

        return [
            'quartile1' => $result[0]->quartile1,
            'quartile3' => $result[0]->quartile3
        ];
    }

    public function make_where_clause( Exam $exam = null, Kumi $kumi = null )
    {
        //We know we will be looking up by item,
        //so we start with that
//        $params = "WHERE item_id = :itemId";
        $params = "";
        //if exam is set, we append that
        if ( isset($exam) ) {
            $params .= " AND exam_id = :examId";
        }

        //todo kumi
        if ( isset($kumi) ) {
        }
        //todo student (if there is a use case)

        return $params;
    }

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
    public function make_values_array( Item $item = null, Exam $exam = null, Kumi $kumi = null, $student = null )
    {
        $values = ['itemId' => $item->id, 'itemId2' => $item->id];

        //if exam is included, set that
        if ( isset($exam) ) {
            $values['examId'] = $exam->id;
            $values['examId2'] = $exam->id;
        }

        //kumi
        if ( isset($kumi) ) $values['kumiId'] = $kumi->id;

        //student
        if ( isset($student) ) $values['studentId'] = $student->id;

        return $values;
    }


// Function to calculate standard deviation (uses sd_square)
    public function sd( $array )
    {
        // Function to calculate square of value - mean

        function sd_square( $x, $mean )
        {
            return pow($x - $mean, 2);
        }

        // square root of sum of squares devided by N-1
        return sqrt(array_sum(array_map("sd_square", $array, array_fill(0, count($array), (array_sum($array) / count($array))))) / (count($array) - 1));
    }

}