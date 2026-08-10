<?php

namespace Database\Factories;

use App\Element;
use App\ElementAssignment;
use App\Exam;
use App\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElementAssignmentFactory extends Factory
{
    protected $model = ElementAssignment::class;

    public function definition(): array
    {
        return ['question_id' => Question::factory(), 'element_id' => Element::factory(), 'exam_id' => Exam::factory(), 'subtask' => $this->faker->randomDigitNotNull];
    }
}
