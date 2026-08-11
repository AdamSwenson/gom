<?php

namespace Database\Factories\NewGom;

use App\Models\NewGom\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'text' => $this->faker->text(),
            'priority' => $this->faker->randomElement(Note::PRIORITY_LEVELS),
            'props' => ['testProp' => 'testVal'],
        ];
    }
}
