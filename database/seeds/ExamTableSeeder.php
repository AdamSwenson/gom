<?php
use Illuminate\Database\Seeder;

use Base\User;
use Map\UserTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

use Propel\Runtime\Propel;


/**
 * Class ExamAndItemSeeder
 *
 * Adds arbitrary data to the exams, questions, and elements tables
 * and their junction tables.
 */
class ExamTableSeeder extends Seeder
{

    public $faker;

    public function run($num=10)
    {
        $this->faker = \Faker\Factory::create();

        DB::table('exams')->delete();
        for ($i = 0; $i < $num; $i++)
        {
            try
            {
                $exam = new \App\Exam();
                $exam->setTerm($this->faker->text(10));
                $exam->setName($this->faker->text(10));
                $exam->setYear($this->faker->year());
                $exam->save();
            } catch (\Exception $e)
            {
//                $i -= 1;
            }
        }
    }


}