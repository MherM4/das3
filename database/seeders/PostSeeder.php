<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Post::factory()->count(11)->create()->each(function ($post) {
        $tags = \App\Models\Tag::inRandomOrder()->limit(rand(1, 2))->pluck('id');
        $post->tags()->attach($tags);
    });
}
}
