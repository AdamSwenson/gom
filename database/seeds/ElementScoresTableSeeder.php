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
                    \App\ElementScore::create([
                        'user_id' => $qa->user_id,
                        'element_assignment_id' => $qa->id,
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
