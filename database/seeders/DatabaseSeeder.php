<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
    \App\Models\User::factory(1)->create();
    \App\Models\SavedArticle::factory(1)->create();
    \App\Models\Discussion::factory(1)->create();
    \App\Models\Comment::factory(2)->create();
    \App\Models\Reply::factory(2)->create();
    }
}
