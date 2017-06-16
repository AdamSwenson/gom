<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/15/17
 * Time: 5:57 PM
 */

namespace App\Repositories\Assignment;

use App\Assignment;
use App\Element;
use App\Exam;
use App\Question;

class AssignmentRepository
{

    static function addChildren( Assignment $assignment, $numSiblings = 5 )
    {
        for ( $k = 0; $k < $numSiblings; $k++ ) {
            $ec = new Assignment(['item_id' => factory(Item::class)->create()->id]);
            $assignment->addChild($ec);
        }
        $assignment->save();
        return $assignment;
    }

    static function makeFake( $numSiblings = 5, $depth = 3 )
    {
        $root = new Assignment(['item_id' => factory(Exam::class)->create()->id]);
        $parent = $root;

        for ( $j = 1; $j < $depth; $j++ ) {
            self::addChildren($parent, $numSiblings);


            foreach ( $parent->getChildren() as $c ) {
                for ( $k = 0; $k < $numSiblings; $k++ ) {
//                    //add elements for the questions
                    $eid = factory(Element::class)->create()->id;
                    $c->addChild(new Assignment(['item_id' => $eid]));
                }

            }
//                //set the element as the new parent for the next level down
            $parent = $ec;
        }

        $root->save();
        return $root;
    }

    public function processIncoming( Exam $exam, $incoming )
    {
        //Get the tree for the exam
        $root = Assignment::where('itemId', $exam->id)->firstOrCreate();

        //check whether there are a different number of questions
//        $root->itemId = $incoming[0]['data']
        //todo Adapt earlier tools for this
    }
}