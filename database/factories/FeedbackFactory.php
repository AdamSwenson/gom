<?php

namespace Database\Factories;

use App\AccessKey;
use App\Feedback;
use App\Repositories\Grade\GradeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        $grade = $this->faker->randomElement(GradeFactory::$grades);
        return ['access_key' => AccessKey::factory(), 'content' => [], 'grade_calc' => $grade['calc_value'], 'grade_display' => $grade['display_value']];
    }
}
