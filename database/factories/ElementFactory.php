<?php

namespace Database\Factories;

use App\Element;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElementFactory extends Factory
{
    protected $model = Element::class;

    public function definition(): array
    {
        return ['elementName' => $this->faker->text(20), 'displayText' => $this->faker->text(200), 'commentText' => $this->faker->paragraph()];
    }
}
