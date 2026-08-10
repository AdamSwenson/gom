<?php

namespace Database\Factories;

use App\QuestionAssignment;
use App\QuestionScore;
use App\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionScoreFactory extends Factory
{
    protected $model = QuestionScore::class;

    public function definition(): array
    {
        return ['question_assignment_id' => QuestionAssignment::factory(), 'student_id' => Student::factory(), 'score' => $this->faker->randomFloat(2, 0, 100)];
    }
}
