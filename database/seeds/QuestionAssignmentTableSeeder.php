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
        $questionIds = \App\Question::lists('id')->toArray();
        $faker = Faker\Factory::create();

        foreach ($exams as $exam)
        {
            for($qnum=1; $qnum <= self::$numQuestionsPerExam; $qnum++)
            {
                try
                {
                    $qa = \App\QuestionAssignment::create(
                        [
                            'exam_id' => $exam->id,
                            'user_id' => $exam->user_id,
                            'question_id' => $faker->randomElement($questionIds),
                            'question_number' => $qnum
                        ]);
                    $qa->save();
                }catch (\Exception $e)
                {
                    $qnum -= 1;
                }
            }
        }
    }

}
