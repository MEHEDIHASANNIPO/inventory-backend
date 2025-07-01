<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::create([
            'site_name'            => 'MHN Inventory',
            'site_tagline'         => 'Inventory Management Simplified',
            'site_email'           => 'indo@mhninventory.com',
            'site_phone'           => '+123 456 7890',
            'site_facebook_link'   => 'https://facebook.com/mhninventory',
            'site_address'         => '123 Demo Street, Dhaka, Bangladesh',
            'meta_keywords'        => 'inventory, stock, management',
            'meta_description'     => 'Powerfull inventory management application for business',
            'meta_author'          => 'MHNLab',
        ]);
    }
}
