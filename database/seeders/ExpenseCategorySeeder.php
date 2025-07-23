<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseCategories = [
            'Office Rent',
            'Utilities',
            'Transportation',
            'Salaries & Wages',
            'Maintenance',
        ];

        foreach ($expenseCategories as $category) {
            ExpenseCategory::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
            ]);
        }

    }
}
