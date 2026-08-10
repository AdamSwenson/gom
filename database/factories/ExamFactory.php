<?php

namespace Database\Factories;

use App\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition(): array
    {
        return [
            'term' => $this->faker->text(10),
            'name' => $this->faker->text(15),
            'year' => $this->faker->year,
            'released' => false,
            'locked' => false,
        ];
    }
}
