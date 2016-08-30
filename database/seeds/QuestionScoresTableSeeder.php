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
        $studentIds = \App\Student::pluck('id')->toArray();

        $faker = Faker\Factory::create();

        foreach ($assigns as $qa)
        {
            foreach($studentIds as $sid)
            {
//            for ($i = 0; $i <= self::$studentsPerQuestion; $i++)
//            {
                try
                {
                    $q =  new \App\QuestionScore();
                    $q->question_assignment_id = $qa->id;
                    $q->student_id = $sid;
                    $q->score = $faker->randomFloat(2, 0, 100);
                    $q->save();
                }catch(\Exception $e)
                {
//                    $i -= 1;
                }
            }
        }
    }
}
