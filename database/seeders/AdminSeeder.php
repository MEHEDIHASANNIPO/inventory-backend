<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => UserRole::ADMIN,
            'name' => 'Admin',
            'email' => 'admin@mhninventory.com',
            'phone' => '+123 456 7890',
            'nid' => '123 456 7890',
            'address' => '47 W 13th St, New York, NY 10011, USA',
            'company_name' => 'MHNLab',
            'password' => Hash::make(1234)
        ]);
    }
}
