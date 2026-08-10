<?php

namespace Database\Factories;

use App\Exam;
use App\GradingTime;
use App\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradingTimeFactory extends Factory
{
    protected $model = GradingTime::class;

    public function definition(): array
    {
        return ['exam_id' => Exam::factory(), 'student_id' => Student::factory(), 'seconds' => $this->faker->randomFloat(2, 0, 1000)];
    }
}
