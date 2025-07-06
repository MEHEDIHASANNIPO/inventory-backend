<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'Dashboard',
            'General Setting',
            'Profile Setting',
            'Change Password',
            'Module Management',
        ];

        foreach ($modules as $module) {
            Module::create([
                'module_name' => $module,
                'module_slug' => Str::slug($module),
            ]);
        }
    }
}
