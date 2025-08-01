<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\ModuleSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\WareHouseSeeder;
use Database\Seeders\SystemSettingSeeder;
use Database\Seeders\ExpenseCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminSeeder::class,
            SystemSettingSeeder::class,
            ModuleSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            WareHouseSeeder::class,
            SupplierSeeder::class,
            ExpenseCategorySeeder::class,
            EmployeeSeeder::class,
            CustomerSeeder::class
        ]);
    }
}
