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
            $lastName = $this->faker->lastName();
            $firstName = $this->faker->firstName();
            $studentId = $this->faker->unique()->randomNumber(9);

            $student = new \App\Student();
            $student->last_name = $lastName;
            $student->first_name = $firstName;
            $student->student_identifier = $studentId;
            $student->email = $this->faker->unique()->email();
            $student->save();
        }
    }
}