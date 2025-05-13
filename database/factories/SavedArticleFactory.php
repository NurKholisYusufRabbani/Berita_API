<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class SavedArticleFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'summary' => $this->faker->paragraph(),
            'section' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
