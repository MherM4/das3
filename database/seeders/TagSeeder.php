<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = ['Cars', 'Nature', 'Another'];

        foreach ($tags as $tagName) {
            Tag::updateOrCreate(['name' => $tagName]);
        }
    }
}
