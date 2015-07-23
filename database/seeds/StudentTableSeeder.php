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
            $student = new \App\Student();
            $student->studentName = $this->faker->unique()->name();
            $student->studentIdentifier = $this->faker->randomNumber(9);
            $student->email = $this->faker->email();
            $student->save();
//
//            ]);
////            $s->setUser(1);
//            $s->save();
        }
    }
}