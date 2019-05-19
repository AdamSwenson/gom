<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/6/17
 * Time: 6:33 PM
 */

namespace App\Repositories\Item;


use App\Exam;

/**
 * Class ItemCommentRepository
 * This is the new version of the gom commenting
 * To avoid too many conflicts with the old system,
 * I've written it to the original interface
 *
 * @package App\Repositories\Element
 */
interface IItemCommentRepository
{
    /**
     * Returns the appropriate comment text for the score
     * @param $itemId
     * @param $score
     * @return mixed
     */
    public function getCommentForScore( $itemId, $score );

    public function getCommentForValence( $itemId, $valence );

    /**
     * Determines which comment valence to load
     * @param $score
     * @return int|string
     * @throws \Exception
     */
    public function chooseValenceByScore( $score );

    /**
     * @param Exam $exam
     * @return mixed
     */
    public function assignDefaultCommentsToGradedItems(Exam $exam);
    }