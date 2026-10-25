<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            // European Brands
            ['name' => 'Bosch', 'slug' => 'bosch', 'description' => 'Premium German engineering for reliable performance', 'logo' => 'brands/bosch.png', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Varta', 'slug' => 'varta', 'description' => 'Trusted European battery manufacturer since 1887', 'logo' => 'brands/varta.png', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Exide', 'slug' => 'exide', 'description' => 'Global leader in stored energy solutions', 'logo' => 'brands/exide.png', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Banner', 'slug' => 'banner', 'description' => 'Austrian quality batteries for all vehicle types', 'logo' => 'brands/banner.png', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'Moll', 'slug' => 'moll', 'description' => 'German premium batteries with innovative technology', 'logo' => 'brands/moll.png', 'is_active' => true, 'sort_order' => 5],
            ['name' => 'Tudor', 'slug' => 'tudor', 'description' => 'Spanish battery specialist since 1895', 'logo' => 'brands/tudor.png', 'is_active' => true, 'sort_order' => 6],
            ['name' => 'Centra', 'slug' => 'centra', 'description' => 'European automotive battery manufacturer', 'logo' => 'brands/centra.png', 'is_active' => true, 'sort_order' => 7],
            ['name' => 'Fiamm', 'slug' => 'fiamm', 'description' => 'Italian energy storage solutions', 'logo' => 'brands/fiamm.png', 'is_active' => true, 'sort_order' => 8],
            ['name' => 'Yuasa', 'slug' => 'yuasa', 'description' => 'Japanese-European joint venture, powersport specialist', 'logo' => 'brands/yuasa.png', 'is_active' => true, 'sort_order' => 9],
            
            // US/Global Brands
            ['name' => 'Optima', 'slug' => 'optima', 'description' => 'High-performance AGM batteries with SPIRALCELL technology', 'logo' => 'brands/optima.png', 'is_active' => true, 'sort_order' => 10],
            ['name' => 'Odyssey', 'slug' => 'odyssey', 'description' => 'Extreme power for extreme conditions, pure lead AGM', 'logo' => 'brands/odyssey.png', 'is_active' => true, 'sort_order' => 11],
            ['name' => 'ACDelco', 'slug' => 'acdelco', 'description' => 'OE quality replacement batteries', 'logo' => 'brands/acdelco.png', 'is_active' => true, 'sort_order' => 12],
            ['name' => 'DieHard', 'slug' => 'diehard', 'description' => 'Legendary durability and power', 'logo' => 'brands/diehard.png', 'is_active' => true, 'sort_order' => 13],
            ['name' => 'Interstate', 'slug' => 'interstate', 'description' => 'America\'s #1 replacement battery', 'logo' => 'brands/interstate.png', 'is_active' => true, 'sort_order' => 14],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}