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
//    use SeederTraits;

//    public $questions;
//    public $elements;
//    public $exams;

    public $faker;

    public function run($num=10)
    {
        $this->faker = \Faker\Factory::create();

        DB::table('exams')->delete();
        for ($i = 0; $i < $num; $i++)
        {
            $exam = new \App\Exam([
                'term' => \Faker\Factory::create()->word(),
                'topic' => $this->faker->word(),
                'year' => $this->faker->year()
            ]);
            $exam->setUser(1);
            $exam->save();
//            \App\Exam::create(
//                [
//                    'term' => \Faker\Factory::create()->word(),
//                    'topic' => $this->faker->word(),
//                    'year' => $this->faker->year()
//                ])->setUser(1)->save();
        }
//        $this->setUp();
//        $this->populate_exams();

    }
//
//    public function populate_exams($num = 10)
//    {
//        try
//        {
//            for ($i = 0; $i < $num; $i++)
//            {
//                $e = \ExamQuery::create()
//                    ->filterByUser($this->user)
//                    ->filterByExamyear($this->faker->year())
//                    ->filterByExamterm($this->faker->word())
//                    ->filterByExamtopic($this->faker->word())
//                    ->findOneOrCreate();
//                $e->save();
//            }
//        } catch (\Exception $e)
//        {
//            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
//        }
//    }


}