<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/25/15
 * Time: 12:38 PM
 */

namespace App\Http\Controllers\helpers\assignments;

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
 */
class AssignmentHelper implements IAssignmentHelper
{
    /** No alterations have been made */
    const CASE_NO_CHANGE = 100;

    /** New items have been added; they do not replace anything old. No effect on student scores */
    const CASE_PURE_ADDITION = 101;

    /** Old items have been removed and not replaced with new items. Delete student scores */
    const CASE_PURE_DELETION = 102;

    /** Some mix of additions, deletions, and reordering has occurred. */
    const CASE_IMPURE = 105;

//    /** Old items have been removed and replaced with new items. Delete student scores*/
//    const CASE_REPLACEMENT = 103;
//
//    /** Old items have been reordered. Keep scores associated with their elements  */
//    const CASE_SHUFFLE = 104;

    /** @var array Ids of items which have not been previously assigned. If a new item, this should be non-0 */
    public $newIds = [];

    /** @var array Ids of items which were previously assigned but are not in the request */
    public $deletedIds = [];

    /**
     * Determines what kind of changes have been made in the request, stores arrays of
     * new and deleted ids, and returns a flag which helps the calling class decide what
     * to do with the request.
     *
     * @param $existingIds array Ordered (ascending) by subtask or questionNumber
     * @param $requestIds array Ordered (ascending) by subtask or questionNumber
     * @return int
     */
    public function determineCase(array $existingIds, array $requestIds)
    {
        /* Easy case: nothing changed */
        if ($existingIds === $requestIds){ return self::CASE_NO_CHANGE; }

        /* Easy case: All element/question assignments are brand new  */
        $numExisting = count($existingIds);
        if ($numExisting == 0) { return self::CASE_PURE_ADDITION; }

        /* Build the deletedIds array. Do this here because the response to pure_deletion
         * will delete everything in the deletedIds array.
         */
        $this->findDeleted($existingIds, $requestIds);

        /* Easy case: All element/question assignments are deleted */
        $numRequest = count($requestIds);
        if ($numRequest == 0) { return self::CASE_PURE_DELETION; }

        /* Build the newIds array. */
        $this->findNew($existingIds, $requestIds);

        return self::CASE_IMPURE;
    }


    /**
     * Populate the $this->newIds array with ids that are present in $requestIds
     * but not in the $existingIds array
     * @param array $existingIds
     * @param array $requestIds
     * @return array
     */
    public function findNew(array $existingIds, array $requestIds)
    {
        $this->newIds = array_values(array_diff($requestIds, $existingIds));
        return $this->newIds;
    }

    /**
     * Populate $this->deletedIds with ids which are present in the existingIds
     * array but not in the requestIds array.
     * @param array $existingIds
     * @param array $requestIds
     * @return array
     */
    public function findDeleted(array $existingIds, array $requestIds)
    {
        $this->deletedIds = array_values(array_diff($existingIds, $requestIds));
        return $this->deletedIds;
    }


//
//    //move to appropriate place later
//
//    public function handle($exam, $request)
//    {
//        //make menus
//        $existingIds = [];
//        $requestIds = [];
//
//        switch ($this->determineCase($existingIds, $requestIds))
//        {
//            case self::CASE_NO_CHANGE:
//                //do nothing
//                break;
//            case self::CASE_PURE_DELETION:
//                //delete the existing assignments (should cascade to delete scores)
//
//                break;
//            case self::CASE_PURE_ADDITION:
//                //add new assignments (no effect on scores)
//                break;
//            case self::CASE_REPLACEMENT:
//                //delete any changed assignments (should cascade to delete scores)
//                break;
//            case self::CASE_SHUFFLE:
//                //Change the subtask or question number fields in the assignment table.
//                //Should not affect scores.
//        }
//
//
//    }
//    public function checkOrder($existingIds, $requestIds)
//    {
//        for ($i = 0; $i < count($requestIds); $i++)
//        {
//            if ($existingIds[$i] !== $requestIds[$i])
//            {
//                $this->changedItems[] = [
//                    'order' => $i,
//                    'existingId' => $existingIds[$i],
//                    'requestId' => $requestIds[$i]
//                ];
//            }
//        }
//
//        return $this->changedItems;
//    }

}
