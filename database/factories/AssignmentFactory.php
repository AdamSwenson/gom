<?php

namespace Database\Factories;

use App\Assignment;
use App\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        return ['item_id' => Item::factory()];
    }
}
