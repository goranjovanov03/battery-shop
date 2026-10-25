<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Total products: " . App\Models\Product::count() . "\n";
echo "Total brands: " . App\Models\Brand::count() . "\n\n";

$products = App\Models\Product::with('brand')->get();
foreach ($products->groupBy('brand.name') as $brand => $items) {
    echo "$brand: " . $items->count() . " products\n";
}