<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/15/17
 * Time: 6:06 PM
 */

namespace App\Repositories\Assignment;


use App\Assignment;
use App\Exam;
use App\Http\Requests\ItemRequest;
use App\Item;

class AssignmentRepositoryTest extends \TestCase
{

    public $exam;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->exam = factory(Exam::class)->create();
        $this->item1 = factory(Item::class)->create();
//$this->item1->save();
        $this->object = new AssignmentRepository;
    }

//    /** @test */
//    public function make_fake(){
//        $result = AssignmentRepository::makeFake();
////        dd($result);
//        echo $result;
//        $this->assertInstanceOf(Assignment::class, $result);
//    //var_dump($result->getChildren());
//    }

    public function makeData( $exam, $numLevels = 3, $numAtLevel = 3 )
    {
        $order = [];

        $root = factory(Item::class)->create(); //standin for exam

        for ( $level = 0; $level < $numLevels; $level++ ) {

            for ( $h = 0; $h < $numAtLevel; $h++ ) {
                $item = factory(Item::class)->create();
                $order[] = [
                    'examId' => $exam->id,
                    'parentId' => $root->id,
                    'itemId' => $item->id,
                    'itemOrder' => $h];
            }
            //On the last time through, we skip
            //Otherwise, we make children
            if ( $level < $numLevels ) {
                for ( $j = 0; $j < $numAtLevel; $j++ ) {
                    $child = factory(Item::class)->create();
                    $order[] = [
                        'examId' => $exam->id,
                        'parentId' => $item->id,
                        'itemId' => $child->id,
                        'itemOrder' => $j];
                }
            }
        }
        return $order;
    }
//        for ( $h = 0; $h < $numAtLevel; $h++ ) {
//
//        }
//        for ( $i = 0; $i < $numLevels; $i++ ) {
//            if ( $i === 0 ) {
//                $parent = factory(Item::class)->create(); //standin for exam
//            }
//            for ( $j = 0; $j < $numAtLevel; $j++ ) {
//                $item = factory(Item::class)->create();
//                $order[] = [
//                    'examId' => $exam->id,
//                    'parentId' => $parent->id,
//                    'itemId' => $item->id,
//                    'itemOrder' => $j];
//            }
//        }
//        return $order;
//    }

    /** @test */
    public function processIncoming()
    {
        $numLevels = 3;
        $numAtLevel = 3;
        $item0 = factory(Item::class)->create(); //sib
        $item1 = factory(Item::class)->create(); //sib
        $item2 = factory(Item::class)->create(); //sib
        $item3 = factory(Item::class)->create(); //child of 1
//        examId: 9, itemId: 81, parentId: 9, itemOrder: 0}
        $order = [
            ['examId' => $this->exam->id, 'parentId' => $item0->id, 'itemId' => $item1->id, 'itemOrder' => 0],
            ['examId' => $this->exam->id, 'parentId' => $item0->id, 'itemId' => $item2->id, 'itemOrder' => 1],
            ['examId' => $this->exam->id, 'parentId' => $item1->id, 'itemId' => $item3->id, 'itemOrder' => 0]];

        //call
        $this->object->processIncoming($this->exam, $order);

        //check
        $assignments = Assignment::where('exam_id', $this->exam->id)->get();

        //Check that the desired records are present
        $this->seeInDatabase('assignments', [
            'exam_id' => $this->exam->id,
            'item_id' => $item1->id,
            'position' => 0]);
        $this->seeInDatabase('assignments', [
            'exam_id' => $this->exam->id,
            'item_id' => $item2->id,
            'position' => 1]);
        $this->seeInDatabase('assignments', [
            'exam_id' => $this->exam->id,
            'item_id' => $item3->id,
//            'parent_id' => Assignment::where('exam_id', $this->exam->id)->
            'position' => 0]);

        //Check tha these are the only records for the exam
        $this->assertEquals(4, $assignments->count());
    }


    /** @test */
    public function getItemOrderForClient()
    {
        $order = $this->makeData($this->exam);
        dd($order);
    }


}
