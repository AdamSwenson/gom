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
use App\Http\Requests\ItemRequest;
use App\Item;
use App\Question;

class AssignmentRepository implements IAssignmentRepository
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
//            $parent = $ec;
        }

        $root->save();
        return $root;
    }

    /**
     * Stores the incoming array from the client in
     * the database.
     * The expected format of incoming is a list of arrays
     * with the form
     *      examId
     *      parentId The id of the item or exam which is the parent
     *      itemId The id of the item in question
     *      itemOrder The sibling order of the item
     * }
     * @param Exam $exam
     * @param $incoming
     */
    public function processIncoming( Exam $exam, $incoming )
    {
        //We start by deleting all of the existing assignments
        //for the exam.
        //todo Wrap in a transaction so this can be rolled back if there is an error
        $exam->resetAssignments();

        //Process the incoming array
        foreach ( $incoming as $record ) {
//            foreach ( collect($incoming)->sortBy('parentId') as $record ) {
            if ( $record['itemId'] !== -1 ) {

                //find the parent
                $item = Item::where('id', $record['itemId'])->first();
                if($item) {
                    $depth = $record['itemOrder'];

                    //we need the assignment id of the parent
                    //to link them, so get the parent assignment
                    //This is okay as long as we can presume that
                    //if we haven't processed the parent
                    //yet, it will be updated when we get to it.
                    $parentAssign = Assignment::firstOrCreate(
                        [
                            'exam_id' => $exam->id,
                            'item_id' => $record['parentId']
                        ]);

                    //Now we can make the actual assignment entry
                    $assignment = Assignment::create([
                        'exam_id' => $exam->id,
                        'item_id' => $item->id,
                    ]);

                    //and finally associate it into the tree.
                    $parentAssign->addChild($assignment, $depth);

                }
            }
        }

        //To clean up, we need to remove a record which was
        //a side effect todo and likely an indication of problems!
        //of the processing.
        //This record was created on the first pass through the incoming array
        //which always includes the exam as its root.
        //We simply put the exam id in as the item id.
        //But this can't serve as the root of the tree,
        //since an item and exam could have the same id (they are
        //in different tables).
        // So we solved it by creating a
        //new item without a parent as the root which has
        //the exam as its exam. This stands in for the exam
        //Thus when we query the exam assignments the root item
        //is this second record.
        //
        //For now, we've left the original record in up to this point.
        //Eventually we will want to avoid creating it in the first place.
        //So let's remove it.
        Assignment::where('item_id', $exam->id)
            ->where('exam_id' , $exam->id)
            ->delete();

    }

    /**
     * This is used on page load to order the items
     * @param $examOrItem
     */
    public function getItemOrderForClient($examOrItem){
        //this needs to have a determinate ordering
        //so that the client can parse it straightforwardly
        $tree = Assignment::getTreeWhere('exam_id', '==', $examOrItem->id);

        dd($tree);
    }
}