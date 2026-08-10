<?php

namespace Database\Factories;

use App\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        $score = $this->faker->randomFloat(2, 1, \DatabaseSeeder::MAX_ITEM_SCORE);

        return [
            'name' => $this->faker->word,
            'displayText' => $this->faker->word,
            'comment_text' => $this->faker->word(),
            'text' => $this->faker->word(),
            'settings' => [],
            'max_score' => \DatabaseSeeder::VARY_MAX_ITEM_SCORES
                ? $score
                : \DatabaseSeeder::MAX_ITEM_SCORE,
        ];
    }
}
