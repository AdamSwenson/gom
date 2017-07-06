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

    public function canBeSynced($record)
    {
        if ( $record['itemId'] === -1 ) return false;

        if ( $record['examId'] === $record['itemId'] && $record['itemOrder'] === 0 ) return false;

        return true;
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
            //check to make sure an unready item hasn't slipped by
            if ( $this->canBeSynced($record) ) {

                //find the item
                $item = Item::where('id', $record['itemId'])->first();

                if($item) {
                    $depth = $record['itemOrder'];

                    //we need the assignment id of the parent
                    //to link them, so get the parent assignment
                    //This is okay as long as we can presume that
                    //if we haven't processed the parent
                    //yet, it will be updated when we get to it.
//                    $parentAssign = $record['itemOrder'] === 0 ? $exam->getAssignmentsRoot() :
                        $parentAssign = Assignment::firstOrCreate(
                        [
                            'exam_id' => $exam->id,
                            'item_id' => $record['parentId']
                        ]);

                    //Now we can make the actual assignment entry
                    $assignment = Assignment::firstOrCreate([
                        'exam_id' => $exam->id,
                        'item_id' => $item->id,
                    ]);
//dd($parentAssign);
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
//        Assignment::where('item_id', $exam->id)
//            ->where('exam_id' , $exam->id)
//            ->delete();

    }

    /**
     * This is used on page load to order the items
     * @param Exam $exam
     * @return array
     * @internal param $examOrItem
     */
    public function getItemOrderForClient(Exam $exam){

        $itemObjects = [];
        $itemOrder = [];

        $assignments = Assignment::where('exam_id', $exam->id)->get();
        foreach ( $assignments as $assignment ) {
            $item = Item::where('id', $assignment->item_id)->first();
            if ( $item ) {
                $itemObjects[] = $item;
                $parentItemAssignment = $assignment->getParent();//Assignment::where('parent_id', $assignment->parent_id)->first();

                $parentItemId = $parentItemAssignment ? $parentItemAssignment->item_id : null;

                $itemOrder[] = [
                    'examId' => $exam->id,
                    'itemId' => $item->id,
                    'parentId' => $parentItemId,
                    'itemOrder' => $assignment->position
                ];
            }
        }

        return [
            'exam' => $exam,
            'itemObjects' => $itemObjects,
            'itemOrder' => $itemOrder
        ];





//        //this needs to have a determinate ordering
//        //so that the client can parse it straightforwardly
////        $tree = Assignment::getTreeWhere('exam_id', '==', $examOrItem->id);
//
//        //exam or item primary key, depending on request
//        $identifier = $examOrItem instanceof Exam ? 'exam_id' : 'item_id';
//
//        //Get the assignments, ignoring the exam whose item_id is null
//        $assignments = Assignment::where($identifier, $examOrItem->id)
//            ->where('item_id', '!==', null)
//            ->get();
//
//        //Put them all in a format for sending to the client
//        foreach ( $assignments as $assignment ) {
//            $item = Item::where('id', $assignment->item_id)->first();
//            if ( $item ) {
//                $itemObjects[] = $item;
//                $parentItemAssignment = $assignment->getParent();//Assignment::where('parent_id', $assignment->parent_id)->first();
//
//                $parentItemId = $parentItemAssignment ? $parentItemAssignment->item_id : null;
//
//                $itemOrder[] = [
//                    'examId' => $assignment->exam_id,
//                    'itemId' => $item->id,
//                    'parentId' => $parentItemId,
//                    'itemOrder' => $assignment->position
//                ];
//            }
//        }
    }
}