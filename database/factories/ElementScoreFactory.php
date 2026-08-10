<?php

namespace Database\Factories;

use App\ElementAssignment;
use App\ElementScore;
use App\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElementScoreFactory extends Factory
{
    protected $model = ElementScore::class;

    public function definition(): array
    {
        return ['element_assignment_id' => ElementAssignment::factory(), 'student_id' => Student::factory(), 'score' => $this->faker->randomFloat(2), 'comment_text' => $this->faker->paragraph()];
    }
}
