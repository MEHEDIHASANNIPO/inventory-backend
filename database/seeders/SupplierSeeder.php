<?php
namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = collect([
            [
                'name'         => 'Supplier 1',
                'email'        => 'supplier1@example.com',
                'phone'        => '2125551001',
                'nid'          => 'abc2125551001',
                'address'      => '101 Market St, New York, NY',
                'company_name' => 'Supplier Company One',
            ],
            [
                'name'         => 'Supplier 2',
                'email'        => 'supplier2@example.com',
                'phone'        => '2125551002',
                'nid'          => 'def2125551002',
                'address'      => '202 Commerce Blvd, Los Angeles, CA',
                'company_name' => 'Supplier Company Two',
            ],
            [
                'name'         => 'Supplier 3',
                'email'        => 'supplier3@example.com',
                'phone'        => '2125551003',
                'nid'          => 'ghi2125551003',
                'address'      => '303 Trade Ave, Chicago, IL',
                'company_name' => 'Supplier Company Three',
            ],
            [
                'name'         => 'Supplier 4',
                'email'        => 'supplier4@example.com',
                'phone'        => '2125551004',
                'nid'          => 'jkl2125551004',
                'address'      => '404 Supply Ln, Dallas, TX',
                'company_name' => 'Supplier Company Four',
            ],
            [
                'name'         => 'Supplier 5',
                'email'        => 'supplier5@example.com',
                'phone'        => '2125551005',
                'nid'          => 'mno2125551005',
                'address'      => '505 Industry Rd, Miami, FL',
                'company_name' => 'Supplier Company Five',
            ],
        ]);

        foreach ($suppliers as $supplier) {
            User::create([
                'role_id'      => UserRole::SUPPLIER,
                'name'         => $supplier['name'],
                'email'        => $supplier['email'],
                'phone'        => $supplier['phone'],
                'nid'          => $supplier['nid'],
                'address'      => $supplier['address'],
                'company_name' => $supplier['company_name'],
                'password'     => Hash::make('1234'),
            ]);
        }
    }
}
