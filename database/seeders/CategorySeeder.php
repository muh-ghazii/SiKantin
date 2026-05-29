<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Makanan'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Snack'],
            ['nama_kategori' => 'Paket Hemat'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}