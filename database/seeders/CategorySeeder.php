<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Fashion',
            'Home & Kitchen',
            'Books',
            'Sports & Outdoors'
        ];

        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
                'category_code' => uniqid() . rand(99, 9999)
            ]);
        }
    }
}
