<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/26/15
 * Time: 2:58 PM
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
interface IAssignmentHelper
{
    /**
     * Determines what kind of changes have been made in the request, stores arrays of
     * new and deleted ids, and returns a flag which helps the calling class decide what
     * to do with the request.
     *
     * @param $existingIds array Ordered (ascending) by subtask or questionNumber
     * @param $requestIds array Ordered (ascending) by subtask or questionNumber
     * @return int
     */
    public function determineCase(array $existingIds, array $requestIds);

    /**
     * Populate the $this->newIds array with ids that are present in $requestIds
     * but not in the $existingIds array
     * @param array $existingIds
     * @param array $requestIds
     * @return array
     */
    public function findNew(array $existingIds, array $requestIds);

    /**
     * Populate $this->deletedIds with ids which are present in the existingIds
     * array but not in the requestIds array.
     * @param array $existingIds
     * @param array $requestIds
     * @return array
     */
    public function findDeleted(array $existingIds, array $requestIds);
}