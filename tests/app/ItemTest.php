<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/8/17
 * Time: 5:41 PM
 */

namespace App;
use App\Assignment;

class ItemTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = \factory(Item::class)->create();
    }


    /** @test */
    public function relationshipToAssignmentsWorks(){
        $itemAssignment = new Assignment(['item_id' => $this->object->id]);
        $itemAssignment->save();

        $result = $this->object->assignments;
        $this->assertEquals($itemAssignment->id, $result->first()->id);
    }

    /** @test */
    public function exams(){
        $exam = factory(Exam::class)->create();
        $itemAssignment = new Assignment(['item_id' => $this->object->id, 'exam_id' => $exam->id]);
        $itemAssignment->save();

        $result = $this->object->exams;
        $this->assertEquals($exam->id, $result->first()->id);
    }

    /** @test */
    public function getExams(){
        $exam = factory(Exam::class)->create();
        $itemAssignment = new Assignment(['item_id' => $this->object->id, 'exam_id' => $exam->id]);
        $itemAssignment->save();

        $result = $this->object->getExams();
        $this->assertEquals($exam->id, $result->first()->id);
    }


    /** @test */
    public function assignments(){

        //prep
        $exam = factory(Exam::class)->create();
        $itemAssignment = new Assignment(['item_id' => $this->object->id, 'exam_id' => $exam->id]);
        $itemAssignment->save();

        $result = [];
        foreach($this->object->assignments as $a){
            $result[] = $a->exam;
        }
        $result = collect($result);

        //check
        $this->assertEquals($exam->id, $result->first()->id);
    }

}
