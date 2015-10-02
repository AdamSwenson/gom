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

    public function run($num = 100)
    {
        $this->faker = \Faker\Factory::create();

        DB::table('students')->delete();
        for ($i = 0; $i < $num; $i++)
        {
            $lastName = $this->faker->lastName();
            $firstName = $this->faker->firstName();


            $student = new \App\Student();
            $student->last_name = $lastName;
            $student->first_name = $firstName;

            //Randomly assign some students student identifiers, others blank
            if(rand(0,1))
            {
                $student->student_identifier = $this->faker->unique()->randomNumber(9);
            }

            //Randomly assign some students email addresses, others blank
            if(rand(0,1))
            {
                $student->email = $this->faker->unique()->email();
//                $student->email = \Illuminate\Support\Facades\Crypt::encrypt($this->faker->unique()->email());
            }

            $student->save();
        }
    }
}