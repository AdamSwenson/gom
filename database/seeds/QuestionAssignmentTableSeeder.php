<?php

use Illuminate\Database\Seeder;

class QuestionAssignmentTableSeeder extends Seeder
{
    static public $numQuestionsPerExam = 5;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('question_assignments')->delete();

        $exams = DB::table('exams')->get();
        $questionIds = \App\Question::pluck('id')->toArray();
        $faker = Faker\Factory::create();

        $qid = 0;
        foreach ($exams as $exam)
        {
            for($qnum=1; $qnum <= self::$numQuestionsPerExam; $qnum++)
            {
                try
                {
        //            $eid = $faker->randomElement($questionIds);
                    $qa = new \App\QuestionAssignment();
                    $qa->exam_id = $exam->id;
                    $qa->question_id = $questionIds[$qid];
                    $qa->question_number = $qnum;

                    $qa->save();
                    $qid += 1;
                }catch (\Exception $e)
                {
                    //$qnum -= 1;
                }
            }
        }
    }

}
