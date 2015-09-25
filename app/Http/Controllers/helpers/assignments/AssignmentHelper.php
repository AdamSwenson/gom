<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/25/15
 * Time: 12:38 PM
 */

namespace App\Http\Controllers\helpers\assignments;


class AssignmentHelper
{

    const CASE_ADDITION = 100;
    const CASE_DELETION = 101;
    const CASE_REPLACEMENT = 102;
    const CASE_SHUFFLE = 104;

    /** @var array Ids of items which have not been previously assigned */
    public $newIds = [];

    /** @var array Ids of items which were previously assigned but are not in the request  */
    public $deletedIds = [];

    /**
     * This covers all assignment possibilities
     *
     * Suppose:
     *      A is an element/question
     *      B is an element/question (A != B)
     *      i is a subtask/questionNumber
     *      j is a subtask/questionNumber (i != j)
     *
     * Case 1 Addition
     *      Prior to request
     *          A is not assigned on the exam
     *          No item is assigned to i
     *      Request
     *          A is assigned to i
     *      Collateral
     *          No effects on scores should be possible
     *
     * Case 2 Replacement
     *      Prior to request
     *          A is assigned to i
     *          B is not assigned on the exam
     *      Request
     *          A is removed from the exam
     *          B is assigned to i
     *      Collateral
     *          Scores for A-i should be deleted
     *              -Delete assignment_id for A-i
     *
     * Case 3 Reshuffle
     *      Prior to request
     *          A is assigned to i
     *          B is assigned to j
     *      Request
     *          A is assigned to j
     *          B is assigned to i
     *      Collateral
     *          Scores for A-i should now be scores for A-j
     *          Scores for B-j should now be scores for B-i
     *              -Thus the assignment ids should not change; just the subtask
     *
     * Case 4 Deletion
     *      Prior to request
     *          A is assigned to i
     *      Request
     *          A is removed from i
     *      Collateral
     *          Scores for A-i should be deleted
     *              -Delete assignment_id for A-i
     *
     *
     * @param $existingIds array
     * @param $requestIds array
     * @return int
     */
    public function determineCase($existingIds, $requestIds)
    {
        $numExisting = count($existingIds);

        /* Check whether any elements/questions have already been assigned  */
        if( $existingIds  == 0){ return self::CASE_ADDITION;}

        /* Check whether something has been have deleted */
        if(count($requestIds) < $numExisting)
        {
            $this->deletedIds = array_diff($existingIds, $requestIds);
            return self::CASE_DELETION;
        }

        /* Check whether something is new  */
        $newIds = array_diff($requestIds, $existingIds);
        if( count($newIds) > 0 )
        {
            $this->newIds = $newIds;
            return self::CASE_REPLACEMENT;
        }

        /* Nothing is new, so existing elements must have been shuffled */
        for($i=0; $i<count($requestIds); $i++)
        {}
        return self::CASE_SHUFFLE;
    }

    public function checkOrder($existingIds, $requestIds)
    {
        $numExisting = count($existingIds);
        $numRequest = count($requestIds);
        if( $numExisting == $numRequest )
        {
            $differenceLocations = [];
            for($i=0; $i<$numExisting; $i++)
            {
                if($existingIds[$i] != $requestIds[$i])
                {
                    $differenceLocations[] = $i;
                }
            }
            return $differenceLocations;
        }
    }

    public function findNew($existingIds, $requestIds)
    {
        return array_diff($requestIds, $existingIds);
    }

    public function findDeleted($existingIds, $requestIds)
    {
        return array_diff($existingIds, $requestIds);
    }

    /**
     * Loads array of element ids from the existing element assignments ordered by subtask
     * @param $examId
     * @param $questionId
     * @return int
     */
    public function load_for_element_assignment($examId, $questionId)
    {
        $query = <<<MYSQL
            SELECT element_id
            FROM element_assignments
            WHERE exam_id = :examId AND question_id = :questionId
            ORDER BY subtask
MYSQL;
        $values = ['examId' => $examId, 'questionId' => $questionId];
        $existingElements = \DB::select($query, $values);

        /* Check whether any elements have been assigned for the question  */
        if( empty($existingElements) || count($existingElements) == 0){ return self::CASE_ADDITION;}

        return $existingElements;
    }

}