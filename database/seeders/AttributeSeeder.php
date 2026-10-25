<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('PRAGMA foreign_keys = OFF;');
        \DB::table('attributes')->truncate();
        \DB::statement('PRAGMA foreign_keys = ON;');

        $attributes = [
            // Vehicle attributes
            ['name' => 'Make', 'slug' => 'make', 'type' => 'select', 'unit' => '', 'options' => null, 'is_filterable' => true, 'sort_order' => 1],
            ['name' => 'Year', 'slug' => 'year', 'type' => 'select', 'unit' => '', 'options' => null, 'is_filterable' => true, 'sort_order' => 2],
            ['name' => 'Model', 'slug' => 'model', 'type' => 'select', 'unit' => '', 'options' => null, 'is_filterable' => true, 'sort_order' => 3],
            ['name' => 'Engine', 'slug' => 'engine', 'type' => 'select', 'unit' => '', 'options' => null, 'is_filterable' => true, 'sort_order' => 4],

            // Battery specifications
            ['name' => 'Voltage', 'slug' => 'voltage', 'type' => 'select', 'unit' => 'V', 'options' => ['6', '12', '24', '36', '48'], 'is_filterable' => true, 'sort_order' => 5],
            ['name' => 'Capacity', 'slug' => 'capacity', 'type' => 'select', 'unit' => 'Ah', 'options' => ['35', '40', '45', '50', '55', '60', '62', '65', '70', '75', '80', '85', '90', '95', '100', '110', '120', '135', '150', '180', '200', '225', '250'], 'is_filterable' => true, 'sort_order' => 6],
            ['name' => 'Cold Cranking Amps (CCA)', 'slug' => 'cca', 'type' => 'select', 'unit' => 'A', 'options' => ['300', '350', '400', '450', '500', '550', '600', '650', '700', '750', '800', '850', '900', '950', '1000', '1100', '1200'], 'is_filterable' => true, 'sort_order' => 7],
            ['name' => 'Reserve Capacity', 'slug' => 'reserve_capacity', 'type' => 'select', 'unit' => 'min', 'options' => ['60', '75', '90', '100', '110', '120', '130', '140', '150', '160', '180', '200', '220', '240', '260', '280', '300'], 'is_filterable' => true, 'sort_order' => 8],
            ['name' => 'Battery Type', 'slug' => 'battery_type', 'type' => 'select', 'unit' => '', 'options' => ['Flooded', 'AGM', 'EFB', 'Gel', 'Lithium'], 'is_filterable' => true, 'sort_order' => 9],
            ['name' => 'Group Size (BCI)', 'slug' => 'group_size', 'type' => 'select', 'unit' => '', 'options' => ['24', '24F', '25', '26', '26R', '27', '27F', '31', '34', '35', '48', '49', '51', '51R', '58', '59', '65', '75', '78', '86', '96R', '4D', '8D', 'GC2', 'GC8', 'GC12'], 'is_filterable' => true, 'sort_order' => 10],
            ['name' => 'Terminal Type', 'slug' => 'terminal_type', 'type' => 'select', 'unit' => '', 'options' => ['Top Post', 'Side Terminal', 'Dual Terminal', 'L-Terminal', 'Flag Terminal', 'Stud Terminal'], 'is_filterable' => true, 'sort_order' => 11],
            ['name' => 'Polarity', 'slug' => 'polarity', 'type' => 'select', 'unit' => '', 'options' => ['Standard (Positive Right)', 'Reversed (Positive Left)'], 'is_filterable' => true, 'sort_order' => 12],
            ['name' => 'Warranty', 'slug' => 'warranty_months', 'type' => 'select', 'unit' => 'months', 'options' => ['12', '18', '24', '30', '36', '42', '48', '60', '72', '84'], 'is_filterable' => true, 'sort_order' => 13],
            ['name' => 'Weight', 'slug' => 'weight', 'type' => 'text', 'unit' => 'kg', 'options' => null, 'is_filterable' => false, 'sort_order' => 14],
            ['name' => 'Dimensions (L x W x H)', 'slug' => 'dimensions', 'type' => 'text', 'unit' => 'mm', 'options' => null, 'is_filterable' => false, 'sort_order' => 15],
            ['name' => 'Chemistry', 'slug' => 'chemistry', 'type' => 'select', 'unit' => '', 'options' => ['Lead-Acid', 'AGM', 'Gel', 'LiFePO4', 'Li-ion'], 'is_filterable' => true, 'sort_order' => 16],
            ['name' => 'Cycle Life', 'slug' => 'cycle_life', 'type' => 'text', 'unit' => 'cycles', 'options' => null, 'is_filterable' => false, 'sort_order' => 17],
            ['name' => 'Self-Discharge Rate', 'slug' => 'self_discharge', 'type' => 'text', 'unit' => '%/month', 'options' => null, 'is_filterable' => false, 'sort_order' => 18],
            ['name' => 'Operating Temperature', 'slug' => 'operating_temp', 'type' => 'text', 'unit' => '°C', 'options' => null, 'is_filterable' => false, 'sort_order' => 19],
        ];

        foreach ($attributes as $attr) {
            Attribute::firstOrCreate(['slug' => $attr['slug']], $attr);
        }
    }
}
