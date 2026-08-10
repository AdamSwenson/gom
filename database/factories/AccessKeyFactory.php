<?php

namespace Database\Factories;

use App\AccessKey;
use App\Exam;
use App\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessKeyFactory extends Factory
{
    protected $model = AccessKey::class;

    public function definition(): array
    {
        return ['access_key' => $this->faker->sha1, 'student_id' => Student::factory(), 'exam_id' => Exam::factory()];
    }
}
