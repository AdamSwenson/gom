<?php

namespace Database\Factories;

use App\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return ['questionName' => $this->faker->text(20), 'questionText' => $this->faker->text(200), 'max_score' => $this->faker->randomElement([10, 25, 100, 200, 1000])];
    }
}
