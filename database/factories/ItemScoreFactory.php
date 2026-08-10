<?php

namespace Database\Factories;

use App\Exam;
use App\Item;
use App\Models\NewGom\ItemScore;
use App\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemScoreFactory extends Factory
{
    protected $model = ItemScore::class;

    public function definition(): array
    {
        return ['item_id' => Item::factory(), 'exam_id' => Exam::factory(), 'student_id' => Student::factory(), 'comment_text' => $this->faker->sentence, 'score' => $this->faker->randomNumber(3)];
    }
}
