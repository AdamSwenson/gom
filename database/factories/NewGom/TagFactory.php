<?php
namespace Database\Factories\NewGom;

use App\Models\NewGom\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'text' => $this->faker->text(),
            'props' => ['testProp' => 'testVal'],
        ];
    }
}
