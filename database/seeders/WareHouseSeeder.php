<?php

namespace Database\Seeders;

use App\Models\WareHouse;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WareHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wareHouses = collect([
            [
                'warehouse_name' => 'Warehouse 1',
                'warehouse_address' => '123 Main St, Los Angeles, CA',
                'warehouse_zipcode' => '90001',
                'warehouse_phone' => '(213) 555-0101',
            ],
            [
                'warehouse_name' => 'Warehouse 2',
                'warehouse_address' => '456 Elm St, Dallas, TX',
                'warehouse_zipcode' => '75201',
                'warehouse_phone' => '(214) 555-0202',
            ],
            [
                'warehouse_name' => 'Warehouse 3',
                'warehouse_address' => '789 Pine Ave, Miami, FL',
                'warehouse_zipcode' => '33101',
                'warehouse_phone' => '(305) 555-0303',
            ],
            [
                'warehouse_name' => 'Warehouse 4',
                'warehouse_address' => '321 Oak Dr, Chicago, IL',
                'warehouse_zipcode' => '60601',
                'warehouse_phone' => '(312) 555-0404',
            ],
            [
                'warehouse_name' => 'Warehouse 5',
                'warehouse_address' => '654 Maple Rd, New York, NY',
                'warehouse_zipcode' => '10001',
                'warehouse_phone' => '(212) 555-0505',
            ],
        ]);

        foreach ($wareHouses as $warehouse) {
            WareHouse::create([
                'warehouse_name' => $warehouse['warehouse_name'],
                'warehouse_slug' => Str::slug($warehouse['warehouse_name']),
                'warehouse_address' => $warehouse['warehouse_address'],
                'warehouse_zipcode' => $warehouse['warehouse_zipcode'],
                'warehouse_phone' => $warehouse['warehouse_phone'],
            ]);
        }
    }
}
