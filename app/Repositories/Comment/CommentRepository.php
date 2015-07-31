<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 3:20 PM
 */

namespace App\Repositories\Comment;


use App\Comment;

class CommentRepository
{


    public function getByValence($elementId, $valence)
    {
        $fuck_you_laravel = array();
        $comments = Comment::onValence($valence)->element->where('element_id', $elementId)->get();
        foreach($comments as $c){
            if ($c->element->id == 10)
            {
                array_push($fuck_you_laravel, $c);
            }
        }
        return $fuck_you_laravel;

//        App\Comment::has('element', '=', 10)->onValence('absent')->get();
    }
}