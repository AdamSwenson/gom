<?php

use Illuminate\Database\Seeder;

class ElementAssignmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param int $numSubtasksPerQuestion
     */
    public function run($numSubtasksPerQuestion=5)
    {

        DB::table('element_assignments')->delete();

        $questionAssigns = DB::table('question_assignments')->get();
        $elementIds = \App\Element::lists('id')->toArray();
        $faker = Faker\Factory::create();

        foreach ($questionAssigns as $qa)
        {
            for($subtask=1; $subtask <= $numSubtasksPerQuestion; $subtask++)
            {
                try
                {
                    $eid = $faker->randomElement($elementIds);
                    $ea = new \App\ElementAssignment();
                    $ea->question_assignment_id = $qa->id;
                    $ea->element_id = $eid;
                    $ea->subtask = $subtask;

                    $ea->save();
                }catch (\Exception $e)
                {
                    $subtask -= 1; //try this insert again, in case duplicated assignment
                }
            }
        }
        //
    }
}
