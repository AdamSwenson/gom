<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 3:20 PM
 */

namespace App\Repositories\Element;


use App\Comment;

class CommentRepository
{
    static public $assignmentCriteria = [
        Comment::VALENCE_ABSENT => [
            'minScore' => 0,
            'maxScore' => 0.25
        ],
        Comment::VALENCE_POOR => [
            'minScore' => 0.26,
            'maxScore' => 4.0
        ],
        Comment::VALENCE_OK => [
            'minScore' => 4.1,
            'maxScore' => 6.9
        ],
        Comment::VALENCE_EXCELLENT => [
            'minScore' => 7.0,
            'maxScore' => 10.0
        ]
    ];


    public function getCommentForValence($elementId, $valence)
    {
        $comment = Comment::where('valence', $valence)->where('element_id', $elementId)->first();
        return $comment;
    }



    /**
     * Determines which comment valence to load
     * @param $score
     * @return int|string
     * @throws \Exception
     */
    public function chooseValenceByScore($score)
    {
        foreach(self::$assignmentCriteria as $k => $v)
        {
            if($score <= $v['maxScore'])
            {
                return $k;
            }
        }
        throw new \Exception('score out of range');
    }



}