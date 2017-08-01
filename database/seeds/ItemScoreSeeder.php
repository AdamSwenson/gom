<?php


use App\Exam;
use App\Item;
use App\Models\NewGom\ItemScore;
use App\Student;

class ItemScoreSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        parent::run();

        DB::table('item_scores')->delete();
        $items = Item::all()->random(5);
        $exams = Exam::all();
        $students = Student::all()->random(5);

        foreach($exams as $exam){
            foreach($items as $item){
                foreach($students as $student){
                    $score =  new ItemScore();
                    $score->exam_id = $exam->id;
                    $score->item_id = $item->id;
                    $score->student_id = $student->id;
                    $score->score = $this->faker->randomFloat(2, 0, 1000);
                    $score->comment_text = $this->faker->word();
                    $score->save();
                }

            }
        }



    }
}
