<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ProductAttributeValue;

$result = ProductAttributeValue::whereHas('attribute', function($q) {
    $q->where('slug', 'model');
})->whereHas('product.attributeValues', function($q) {
    $q->whereHas('attribute', function($a) {
        $a->where('slug', 'make');
    })->where('value', 'BMW');
})->distinct()->pluck('value')->toArray();

print_r($result);