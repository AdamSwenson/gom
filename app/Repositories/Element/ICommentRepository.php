<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 10:09 PM
 */
namespace App\Repositories\Element;

interface ICommentRepository
{


    /**
     * Returns the appropriate comment text for the score
     *
     * This is the main publicly called method.
     *
     *
     *
     *
     * @param $elementId
     * @param $score
     * @return mixed
     * @throws \Exception
     */
    public function getCommentForScore($elementId, $score);


    public function getCommentForValence($elementId, $valence);

    /**
     * Determines which comment valence to load
     * @param $score
     * @return int|string
     * @throws \Exception
     */
    public function chooseValenceByScore($score);
}