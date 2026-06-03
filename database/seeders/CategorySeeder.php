<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'hy' => 'Տնտեսություն',
                    'en' => 'Economy',
                ],
            ],
            [
                'name' => [
                    'hy' => 'Սպորտ',
                    'en' => 'Sport',
                ],
            ],
            [
                'name' => [
                    'hy' => 'Տեխնոլոգիաներ',
                    'en' => 'Technologies',
                ],
            ],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
            ]);
        }
    }
}
