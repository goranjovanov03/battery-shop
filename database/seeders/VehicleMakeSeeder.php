<?php

namespace Database\Seeders;

use App\Models\VehicleMake;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleMakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makes = [
            ['name' => 'Audi', 'slug' => 'audi', 'sort_order' => 1],
            ['name' => 'BMW', 'slug' => 'bmw', 'sort_order' => 2],
            ['name' => 'Mercedes-Benz', 'slug' => 'mercedes-benz', 'sort_order' => 3],
            ['name' => 'Volkswagen', 'slug' => 'volkswagen', 'sort_order' => 4],
            ['name' => 'Ford', 'slug' => 'ford', 'sort_order' => 5],
            ['name' => 'Toyota', 'slug' => 'toyota', 'sort_order' => 6],
            ['name' => 'Honda', 'slug' => 'honda', 'sort_order' => 7],
            ['name' => 'Nissan', 'slug' => 'nissan', 'sort_order' => 8],
            ['name' => 'Hyundai', 'slug' => 'hyundai', 'sort_order' => 9],
            ['name' => 'Kia', 'slug' => 'kia', 'sort_order' => 10],
            ['name' => 'Volvo', 'slug' => 'volvo', 'sort_order' => 11],
            ['name' => 'Peugeot', 'slug' => 'peugeot', 'sort_order' => 12],
            ['name' => 'Renault', 'slug' => 'renault', 'sort_order' => 13],
            ['name' => 'Fiat', 'slug' => 'fiat', 'sort_order' => 14],
            ['name' => 'Opel', 'slug' => 'opel', 'sort_order' => 15],
            ['name' => 'Skoda', 'slug' => 'skoda', 'sort_order' => 16],
            ['name' => 'Seat', 'slug' => 'seat', 'sort_order' => 17],
            ['name' => 'Mazda', 'slug' => 'mazda', 'sort_order' => 18],
            ['name' => 'Mitsubishi', 'slug' => 'mitsubishi', 'sort_order' => 19],
            ['name' => 'Suzuki', 'slug' => 'suzuki', 'sort_order' => 20],
        ];

        foreach ($makes as $make) {
            VehicleMake::create([
                'name' => $make['name'],
                'slug' => $make['slug'],
                'is_active' => true,
                'sort_order' => $make['sort_order'],
            ]);
        }
    }
}