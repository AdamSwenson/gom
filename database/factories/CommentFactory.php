<?php

namespace Database\Factories;

use App\Comment;
use App\Element;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return ['element_id' => Element::factory(), 'valence' => $this->faker->randomElement(Comment::$valences), 'body' => $this->faker->text(200)];
    }
}
