<?php

namespace Database\Factories;

use App\Exam;
use App\Question;
use App\QuestionAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionAssignmentFactory extends Factory
{
    protected $model = QuestionAssignment::class;

    public function definition(): array
    {
        return ['question_id' => Question::factory(), 'exam_id' => Exam::factory(), 'question_number' => $this->faker->randomDigitNotNull];
    }
}
