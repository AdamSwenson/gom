<?php

use Illuminate\Database\Seeder;

class ElementScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param int $studentsPerQuestion
     */
    public function run($studentsPerQuestion=5)
    {

        DB::table('element_scores')->delete();

        $assigns = DB::table('element_assignments')->get();
        $studentIds = \App\Student::lists('id')->toArray();

        $faker = Faker\Factory::create();

        foreach ($assigns as $qa)
        {
            for ($i = 0; $i <= $studentsPerQuestion; $i++)
            {
                try
                {
                    $sid = $faker->randomElement($studentIds);;
//                    var_dump($sid);
                    $score = $faker->randomFloat(2, 0, 10);
//                    var_dump($score);
                    $e = new \App\ElementScore();
                    $e->element_assignment_id = $qa->id;
                    $e->student_id = $sid;
                    $e->score = $score;
                    $e->save();
                }catch(\Exception $e)
                {
                  //  $i -= 1;
                }
            }
        }
    }
}
