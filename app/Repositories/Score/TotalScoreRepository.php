<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 11/4/18
 * Time: 12:32 PM
 * @version >=0.2.0
 */


namespace App\Repositories\Score;

use Illuminate\Support\Facades\DB;
use App\Exam;

/**
 * This handles calculating statistics on scores.
 * On the first call for an exam, it will load the stats and hold them internally for subsequent calls
 *
 * @package App\Repositories\Score
 */
class TotalScoreRepository implements ITotalScoreRepository
{

    /**
     * Returns just the total score for each student on the exam
     * in descending order
     *
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

        $scores = [];

        if(sizeof($result) > 0) {
            foreach ( $result as $r ) {
                $scores[] = $r->totalScore;
            }
        }

        //sort the scores before returning
        return collect($scores)->sort();

    }

}