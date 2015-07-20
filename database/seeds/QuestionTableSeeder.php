<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/18/15
 * Time: 11:27 AM
 */
use Illuminate\Database\Seeder;


/**
 * Class QuestionTableSeeder
 * Seeds the question table
 */
class QuestionTableSeeder extends Seeder
{
    public $faker;

    public function run($num = 20)
    {
        $this->faker = \Faker\Factory::create();

        DB::table('questions')->delete();
        for ($i = 0; $i < $num; $i++)
        {
            $question = new \App\Question([
                'questionName' => $this->faker->text(20),
                'questionText' => $this->faker->text(200),
            ]);
            $question->setUser(1);
            $question->save();
        }
    }
}