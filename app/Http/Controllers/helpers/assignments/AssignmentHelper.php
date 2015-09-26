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
    /** No alterations have been made */
    const CASE_NO_CHANGE = 100;

    /** New items have been added; they do not replace anything old. No effect on student scores */
    const CASE_PURE_ADDITION = 101;

    /** Old items have been removed and not replaced with new items. Delete student scores */
    const CASE_PURE_DELETION = 102;

    /** Old items have been removed and replaced with new items. Delete student scores*/
    const CASE_REPLACEMENT = 103;

    /** Old items have been reordered. Keep scores associated with their elements  */
    const CASE_SHUFFLE = 104;

    /** @var array Ids of items which have not been previously assigned */
    public $newIds = [];

    /** @var array Ids of items which were previously assigned but are not in the request */
    public $deletedIds = [];
    protected $requestIds;

    public $changedItems = [];

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
     * @param $existingIds array Ordered (ascending) by subtask or questionNumber
     * @param $requestIds array Ordered (ascending) by subtask or questionNumber
     * @return int
     */
    public function determineCase($existingIds, $requestIds)
    {
        /* Easy case: nothing changed */
        if ($existingIds === $requestIds)
        {
            return self::CASE_NO_CHANGE;
        }

        /* Easy case: All element/question assignments are brand new  */
        $numExisting = count($existingIds);
        if ($numExisting == 0)
        {
            return self::CASE_PURE_ADDITION;
        }

        /* Easy case: All element/question assignments are deleted */
        $numRequest = count($requestIds);
        if ($numRequest == 0)
        {
            return self::CASE_PURE_DELETION;
        }

        $this->findDeleted($existingIds, $requestIds);

        $this->findNew($existingIds, $requestIds);

        /* Check whether items have been have deleted */
//        if (count($requestIds) < $numExisting)
//        {
//            $this->deletedIds = array_diff($existingIds, $requestIds);
//
//            return self::CASE_DELETION;
//        }

        /* Check whether something is new  */
        $newIds = array_diff($requestIds, $existingIds);
        if (count($newIds) > 0)
        {
            $this->newIds = $newIds;

            return self::CASE_REPLACEMENT;
        }

        /* Nothing is new, so existing elements must have been shuffled */
        if (count($this->deletedIds) == 0 && count($this->newIds) == 0)
        {
            for ($i = 0; $i < count($requestIds); $i++)
            {
                if ($existingIds[$i] !== $requestIds[$i])
                {
                    $this->changedItems[] = [
                        'order' => $i,
                        'existingId' => $existingIds[$i],
                        'requestId' => $requestIds[$i]
                    ];
                }
            }

        }

        return self::CASE_SHUFFLE;
    }

    public function checkOrder($existingIds, $requestIds)
    {
        $numExisting = count($existingIds);
        $numRequest = count($requestIds);
        if ($numExisting == $numRequest)
        {
            $differenceLocations = [];
            for ($i = 0; $i < $numExisting; $i++)
            {
                if ($existingIds[$i] != $requestIds[$i])
                {
                    $differenceLocations[] = $i;
                }
            }

            return $differenceLocations;
        }
    }

    public function findNew($existingIds, $requestIds)
    {
        $this->newIds = array_diff($requestIds, $existingIds);

        return $this->newIds;
    }

    public function findDeleted($existingIds, $requestIds)
    {
        $this->deletedIds = array_diff($existingIds, $requestIds);

        return $this->deletedIds;
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
        if (empty($existingElements) || count($existingElements) == 0)
        {
            return self::CASE_ADDITION;
        }

        return $existingElements;
    }

    //move to appropriate place later

    public function handle($exam, $request)
    {
        //make lists
        $existingIds = [];
        $requestIds = [];

        switch ($this->determineCase($existingIds, $requestIds))
        {
            case self::CASE_NO_CHANGE:
                //do nothing
                break;
            case self::CASE_PURE_DELETION:
                //delete the existing assignments (should cascade to delete scores)

                break;
            case self::CASE_PURE_ADDITION:
                //add new assignments (no effect on scores)
                break;
            case self::CASE_REPLACEMENT:
                //delete any changed assignments (should cascade to delete scores)
                break;
            case self::CASE_SHUFFLE:
                //Change the subtask or question number fields in the assignment table.
                //Should not affect scores.
        }


    }


}
