<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Top-level categories
            ['name' => 'Car Batteries', 'slug' => 'car-batteries', 'description' => 'Automotive starting batteries for cars and light trucks', 'image' => 'categories/car-batteries.jpg', 'is_active' => true, 'sort_order' => 1, 'parent_id' => null],
            ['name' => 'Truck & Commercial', 'slug' => 'truck-commercial', 'description' => 'Heavy-duty batteries for commercial vehicles', 'image' => 'categories/truck-commercial.jpg', 'is_active' => true, 'sort_order' => 2, 'parent_id' => null],
            ['name' => 'Motorcycle & Powersports', 'slug' => 'motorcycle-powersports', 'description' => 'Batteries for motorcycles, ATVs, and watercraft', 'image' => 'categories/motorcycle.jpg', 'is_active' => true, 'sort_order' => 3, 'parent_id' => null],
            ['name' => 'Marine & RV', 'slug' => 'marine-rv', 'description' => 'Deep cycle and dual-purpose batteries for boats and RVs', 'image' => 'categories/marine-rv.jpg', 'is_active' => true, 'sort_order' => 4, 'parent_id' => null],
            ['name' => 'Lawn & Garden', 'slug' => 'lawn-garden', 'description' => 'Batteries for mowers, tractors, and outdoor equipment', 'image' => 'categories/lawn-garden.jpg', 'is_active' => true, 'sort_order' => 5, 'parent_id' => null],
            ['name' => 'Golf Cart & EV', 'slug' => 'golf-cart-ev', 'description' => 'Deep cycle batteries for golf carts and electric vehicles', 'image' => 'categories/golf-cart.jpg', 'is_active' => true, 'sort_order' => 6, 'parent_id' => null],
        ];

        $created = [];
        foreach ($categories as $cat) {
            $created[] = Category::create($cat);
        }

        // Subcategories for Car Batteries
        $carBatteries = Category::where('slug', 'car-batteries')->first();
        $subCategories = [
            ['name' => 'Standard Flooded', 'slug' => 'standard-flooded', 'description' => 'Traditional lead-acid batteries', 'is_active' => true, 'sort_order' => 1, 'parent_id' => $carBatteries->id],
            ['name' => 'AGM', 'slug' => 'agm-car', 'description' => 'Absorbent Glass Mat for start-stop vehicles', 'is_active' => true, 'sort_order' => 2, 'parent_id' => $carBatteries->id],
            ['name' => 'EFB', 'slug' => 'efb', 'description' => 'Enhanced Flooded Battery for start-stop', 'is_active' => true, 'sort_order' => 3, 'parent_id' => $carBatteries->id],
            ['name' => 'Lithium', 'slug' => 'lithium-car', 'description' => 'Lightweight lithium-ion car batteries', 'is_active' => true, 'sort_order' => 4, 'parent_id' => $carBatteries->id],
        ];

        foreach ($subCategories as $sub) {
            Category::create($sub);
        }

        // Subcategories for Truck & Commercial
        $truckCommercial = Category::where('slug', 'truck-commercial')->first();
        $truckSubs = [
            ['name' => 'Group 31', 'slug' => 'group-31', 'description' => 'Standard heavy-duty truck battery', 'is_active' => true, 'sort_order' => 1, 'parent_id' => $truckCommercial->id],
            ['name' => 'Group 4D/8D', 'slug' => 'group-4d-8d', 'description' => 'Extra large commercial batteries', 'is_active' => true, 'sort_order' => 2, 'parent_id' => $truckCommercial->id],
            ['name' => 'AGM Commercial', 'slug' => 'agm-commercial', 'description' => 'Maintenance-free AGM for fleets', 'is_active' => true, 'sort_order' => 3, 'parent_id' => $truckCommercial->id],
        ];

        foreach ($truckSubs as $sub) {
            Category::create($sub);
        }

        // Subcategories for Marine & RV
        $marineRv = Category::where('slug', 'marine-rv')->first();
        $marineSubs = [
            ['name' => 'Deep Cycle', 'slug' => 'deep-cycle', 'description' => 'For trolling motors and house power', 'is_active' => true, 'sort_order' => 1, 'parent_id' => $marineRv->id],
            ['name' => 'Dual Purpose', 'slug' => 'dual-purpose', 'description' => 'Starting and deep cycle combined', 'is_active' => true, 'sort_order' => 2, 'parent_id' => $marineRv->id],
            ['name' => 'AGM Marine', 'slug' => 'agm-marine', 'description' => 'Spill-proof marine batteries', 'is_active' => true, 'sort_order' => 3, 'parent_id' => $marineRv->id],
            ['name' => 'Lithium Marine', 'slug' => 'lithium-marine', 'description' => 'Lightweight lithium for marine use', 'is_active' => true, 'sort_order' => 4, 'parent_id' => $marineRv->id],
        ];

        foreach ($marineSubs as $sub) {
            Category::create($sub);
        }
    }
}
