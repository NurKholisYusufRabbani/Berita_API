<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Discussion;

class CommentFactory extends Factory
{
    public function definition()
    {
        return [
            'discussion_id' => Discussion::inRandomOrder()->first()->id ?? Discussion::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'content' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
