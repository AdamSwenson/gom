<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/18/15
 * Time: 12:00 PM
 */



class StudentTableSeeder extends Seeder
{

    public $faker;

    public function run($num = 10)
    {
        $this->faker = \Faker\Factory::create();

        DB::table('students')->delete();
        for ($i = 0; $i < $num; $i++)
        {
            $s = new \App\Student([
                'studentName' => $this->faker->name(),
                'studentId' => $this->faker->numberBetween(100000000, 999999999),
                'email' => $this->faker->email()
            ]);
            $s->setUser(1);
            $s->save();
        }
    }
}