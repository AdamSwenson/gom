<?php

namespace Database\Factories;

use App\Kumi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KumiFactory extends Factory
{
    protected $model = Kumi::class;

    public function definition(): array
    {
        return [
            'year' => $this->faker->year,
            'name' => $this->faker->text(30),
        ];
    }
}
