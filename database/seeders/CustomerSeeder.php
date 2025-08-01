<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
            public function run(): void
            {
                $customers = collect([
            [
                'name'  => 'Customer 1',
                'email' => 'customer1@example.com',
                'phone' => '2155552001',
            ],
            [
                'name'  => 'Customer 2',
                'email' => 'customer2@example.com',
                'phone' => '2155552002',
            ],
            [
                'name'  => 'Customer 3',
                'email' => 'customer3@example.com',
                'phone' => '2155552003',
            ],
            [
                'name'  => 'Customer 4',
                'email' => 'customer4@example.com',
                'phone' => '2155552004',
            ],
            [
                'name'  => 'Customer 5',
                'email' => 'customer5@example.com',
                'phone' => '2155552005',
            ],
        ]);

        foreach ($customers as $customer) {
            User::create([
                'role_id'  => UserRole::CUSTOMER,
                'name'     => $customer['name'],
                'email'    => $customer['email'],
                'phone'    => $customer['phone'],
                'password' => Hash::make('1234'),
            ]);
        }
    }
}
