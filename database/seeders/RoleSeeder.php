<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $permissions = Permission::select('id')->get();

        Role::create([
            'role_name' => 'Admin',
            'role_slug' => 'admin',
            'role_note' => 'Admin have all permissions',
        ])->permissions()->sync($permissions->pluck('id'));
    }
}
