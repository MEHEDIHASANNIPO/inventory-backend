<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            "HP",
            "Asus",
            "Xiaomi",
            "Dell",
            "Lenovo",
            "Samsung",
            "Apple",
            "Acer",
            "MSI",
            "Huawei"
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'brand_name' => $brand,
                'brand_slug' => Str::slug($brand),
                'brand_code' => uniqid() . rand(99, 9999)
            ]);
        }
    }
}
