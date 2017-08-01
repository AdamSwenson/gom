<?php

use App\Assignment;
use App\Exam;
use App\Item;
use App\Repositories\Assignment\AssignmentRepository;
use Illuminate\Database\Seeder;

class AssignmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $numAtLevel = 4;
//        $numLevels = 3;
//        DB::table('assignments')->delete();
//
//        $exam = factory(Exam::class)->create();
//        $items = factory(Item::class, $numLevels * $numAtLevel)->create();
//
////        AssignmentRepository::makeFake($numAtLevel, $numLevels);
//        // make initial exam assignment to itself
//        $parent = Assignment::create(['exam_id' => $exam->id,
//            'item_id' => $exam->id,
//            'position' => 0]);
//        $cnt = 0;
//
//        for ( $level = 1; $level <= $numLevels; $level++ ) {
//            for ( $position = 0; $position <= $numAtLevel; $numAtLevel++ ) {
//                $item = $items[$cnt];
//
//                $a = Assignment::create([
//                    'exam_id' => $exam->id,
//                    'item_id' => $item->id]);
//
//                $parent->setChild($a, $position);
//                //set as new parent
//                $parent =
//                $cnt += 1;
//            }
//
//
//        }
//        //
    }
}
