<?php

use Illuminate\Database\Seeder;

class QuestionScoresTableSeeder extends Seeder
{

public static $studentsPerQuestion = 5;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('question_scores')->delete();
        $assigns = DB::table('question_assignments')->get();
        $studentIds = \App\Student::lists('id')->toArray();

        $faker = Faker\Factory::create();

        foreach ($assigns as $qa)
        {
            for ($i = 0; $i <= self::$studentsPerQuestion; $i++)
            {
                try
                {
                    \App\QuestionScore::create([
//                        'user_id' => $qa->user_id,
                        'question_assignment_id' => $qa->id,
                        'student_id' => $faker->randomElement($studentIds),
                        'score' => $faker->randomFloat(2, 0, 10)
                    ]);
                }catch(\Exception $e)
                {
                    $i -= 1;
                }
            }
        }
    }
}
