<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Comment;

class ReplyFactory extends Factory
{
    public function definition()
    {
        return [
            'comment_id' => Comment::inRandomOrder()->first()->id ?? Comment::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'content' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
