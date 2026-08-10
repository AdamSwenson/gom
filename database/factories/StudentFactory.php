<?php

namespace Database\Factories;

use App\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'student_identifier' => $this->faker->randomNumber(9),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'email' => $this->faker->email,
        ];
    }
}
