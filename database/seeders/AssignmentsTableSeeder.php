<?php
namespace Database\Seeders;


use App\Assignment;
use App\Exam;
use App\Item;
use App\Kumi;
use App\Repositories\Assignment\AssignmentRepository;
use App\Repositories\Assignment\IAssignmentRepository;
use Illuminate\Database\Seeder;

class AssignmentsTableSeeder extends Seeder
{
    public $numAtLevel = 2;
    public $numLevels = 2;


    /**
     * Takes an exam and Assignment and gives it
     * the number of children at the level
     *
     * @param Exam $exam
     * @param Assignment $parentAssign
     * @param $numberChildren
     */
    static public function createLevel( Exam $exam, Assignment $parentAssign, $numberChildren )
    {
        $items = Item::factory()->count($numberChildren)->create();

        foreach ( $items as $item ) {
            //Create the assignment for the new item
            $assignment = Assignment::create([
                'exam_id' => $exam->id,
                'item_id' => $item->id,
            ]);
            //and associate it with its proud parent
            $parentAssign->addChild($assignment);
        }
    }


    /**
     * Populates a given exam with new items
     *
     * @param $exam
     * @param $numLevels
     * @param $numAtLevel
     */
    static public function populateExam( Exam $exam, $numLevels, $numAtLevel )
    {
        //initialize the exam's assignments. This will
        //create the root assignment (the Assignment which ties
        //the exam to its immediate children)
        $exam->resetAssignments();

        $examAssignment = $exam->getAssignmentRoot();

        for ( $level = 0; $level < $numLevels; $level++ ) {

            if ( $level === 0 ) {
                //at the top level, we just add items to the exam
                AssignmentsTableSeeder::createLevel($exam, $examAssignment, $numAtLevel);

            } else {
                //if we're not at the top level, we can take a
                //shortcut by noticing that real_depth is equal to $level
                //So we can load all the item assignments at the current level
                $assignments = Assignment::where('exam_id', $exam->id)
                    ->where('real_depth', $level)
                    ->get();

                //iterate through the assignments that were created in the last round
                foreach ( $assignments as $assignment ) {
                    //give each assignment its very own children
                    AssignmentsTableSeeder::createLevel($exam, $assignment, $numAtLevel);
                }
            }
        }
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignments')->delete();

        //create a new exam
        $exam = Exam::factory()->create();

        self::populateExam($exam, $this->numLevels, $this->numAtLevel);

        CompleteNewSetupSeeder::makeCompleteExam(2, 2, 2, 2);
    }
}



//        new Assignment(['item_id' => $item->id]);
//        $itemAssignment->save();
//
//        if ( $level === 0 ) {
//            $exam->addAssignment($itemAssignment, $exam->id, $level);
//
//        }
//    }
//
//$assignment->addChild($ec);
//for ($k = 0;
//$k < $numLevels;
//$k++)
//{
//
//
//}
//
//for ( $k = 0; $k < $numChildren; $k++ ) {
//    $ec = new Assignment(['item_id' => factory(Item::class)->create()->id]);
//    $assignment->addChild($ec);
//}
//$assignment->save();
//
//
//for ( $level = 0; $level < $numLevels; $level++ ) {
//
//    if ( $level === 0 ) {
//        //at the top level, we just add items to the exam
//        $parentId = $exam->id;
////                $exam->addAssignment(factory(Item::class)->create(), $parentId, $level);
//    } else {
//        $assignments = Assignment::where('exam_id', $exam->id)->get();
//        foreach ( $assignments as $assignment ) {
//
//
//        }
//        //$this->app->make(IAssignmentRepository::class);
//        AssignmentRepository::addChildren($assignment, $parentId, $level);
////the next level is trickier
//        for ( $i = 0; $i < $numAtLevel; $i++ ) {
//            $item = factory(Item::class)->create();
//
//        }
//
//    }
//
//
//    //This is the base assignment
//    $baseAssign = Assignment::firstOrCreate(
//        [
//            'exam_id' => $exam->id,
//            'item_id' => null
//        ]);
//
//    //first level
//    self::createLevel($exam, $baseAssign, $numAtLevel);
//
//
//}
//////        AssignmentRepository::makeFake($numAtLevel, $numLevels);
////        // make initial exam assignment to itself
////        $parent = Assignment::create(['exam_id' => $exam->id,
////            'item_id' => $exam->id,
////            'position' => 0]);
////        $cnt = 0;
////
////        for ( $level = 1; $level <= $numLevels; $level++ ) {
////            for ( $position = 0; $position <= $numAtLevel; $numAtLevel++ ) {
////                $item = $items[$cnt];
////
////                $a = Assignment::create([
////                    'exam_id' => $exam->id,
////                    'item_id' => $item->id]);
////
////                $parent->setChild($a, $position);
////                //set as new parent
////                $parent =
////                $cnt += 1;
////            }
////
//
////        }
////
////    }
//}
