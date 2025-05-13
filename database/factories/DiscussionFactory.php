<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SavedArticle;

class DiscussionFactory extends Factory
{
    public function definition()
    {
        return [
            'saved_article_id' => SavedArticle::inRandomOrder()->first()->id ?? SavedArticle::factory(),
            'title' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
