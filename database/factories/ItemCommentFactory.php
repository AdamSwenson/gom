<?php

namespace Database\Factories;

use App\Item;
use App\ItemComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemCommentFactory extends Factory
{
    protected $model = ItemComment::class;

    public function definition(): array
    {
        return ['item_id' => Item::factory(), 'valence' => $this->faker->randomElement(ItemComment::$valenceTexts), 'body' => $this->faker->paragraph()];
    }
}
