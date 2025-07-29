<?php
namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = collect([
            [
                'name'         => 'Employee 1',
                'email'        => 'employee1@example.com',
                'phone'        => '2125552001',
                'nid'          => 'abc2125552001',
                'address'      => '101 Market St, New York, NY',
            ],
            [
                'name'         => 'Employee 2',
                'email'        => 'employee2@example.com',
                'phone'        => '2125552002',
                'nid'          => 'def2125552002',
                'address'      => '202 Commerce Blvd, Los Angeles, CA',
            ],
            [
                'name'         => 'Employee 3',
                'email'        => 'employee3@example.com',
                'phone'        => '2125552003',
                'nid'          => 'ghi2125552003',
                'address'      => '303 Trade Ave, Chicago, IL',
            ],
            [
                'name'         => 'Employee 4',
                'email'        => 'employee4@example.com',
                'phone'        => '2125552004',
                'nid'          => 'jkl2125552004',
                'address'      => '404 Supply Ln, Dallas, TX',
            ],
            [
                'name'         => 'Employee 5',
                'email'        => 'employee5@example.com',
                'phone'        => '2125552005',
                'nid'          => 'mno2125552005',
                'address'      => '505 Industry Rd, Miami, FL',
            ],
        ]);

        foreach ($employees as $employee) {
            User::create([
                'role_id'      => UserRole::EMPLOYEE,
                'name'         => $employee['name'],
                'email'        => $employee['email'],
                'phone'        => $employee['phone'],
                'nid'          => $employee['nid'],
                'address'      => $employee['address'],
                'password'     => Hash::make('1234'),
            ]);
        }
    }
}
