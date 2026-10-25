<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ProductAttributeValue;
use App\Models\VehicleMake;

$make = 'BMW';

$vehicleMake = VehicleMake::where('name', $make)->first();
echo "VehicleMake found: " . ($vehicleMake ? $vehicleMake->name : 'null') . "\n";

$modelsFromAttribute = ProductAttributeValue::whereHas('attribute', function($q) {
    $q->where('slug', 'model');
})->whereHas('product.attributeValues', function($q) use ($make) {
    $q->whereHas('attribute', function($a) {
        $a->where('slug', 'make');
    })->where('value', $make);
})->distinct()->pluck('value')->toArray();

echo "Models from attribute: ";
print_r($modelsFromAttribute);

if ($vehicleMake) {
    $modelsFromVehicleMake = \App\Models\Product::where('vehicle_make_id', $vehicleMake->id)
        ->whereHas('attributeValues', function($q) {
            $q->whereHas('attribute', function($a) {
                $a->where('slug', 'model');
            });
        })->with('attributeValues')->get()->flatMap(function($product) {
            return $product->attributeValues
                ->where('attribute.slug', 'model')
                ->pluck('value');
        })->filter()->unique()->sort()->values()->toArray();

    echo "Models from vehicle_make_id: ";
    print_r($modelsFromVehicleMake);
}