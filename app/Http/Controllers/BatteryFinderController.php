<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\VehicleMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BatteryFinderController extends Controller
{
    public function index()
    {
        // Get vehicle makes from the VehicleMake model (admin managed)
        $makes = VehicleMake::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        // Get unique values for other vehicle attributes from products
        $years = $this->getUniqueValues('year');
        $models = $this->getUniqueValues('model');
        $engines = $this->getUniqueValues('engine');

        // Get all filterable attributes for battery specs
        $attributes = Attribute::where('is_filterable', true)
            ->orderBy('sort_order')
            ->get();

        return view('battery-finder.index', compact('makes', 'years', 'models', 'engines', 'attributes'));
    }

    public function search(Request $request)
    {
        $query = Product::with(['brand', 'category', 'images', 'attributeValues.attribute', 'vehicleMake'])
            ->where('is_active', true);

        // Vehicle filters - make can be filtered by vehicle_make_id or attribute
        if ($request->filled('make')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('vehicleMake', fn ($vm) => $vm->where('name', $request->make))
                  ->orWhereHas('attributeValues', function ($av) use ($request) {
                      $av->whereHas('attribute', fn ($a) => $a->where('slug', 'make'))
                         ->where('value', $request->make);
                  });
            });
        }

        if ($request->filled('year')) {
            $query->whereHas('attributeValues', function ($q) use ($request) {
                $q->whereHas('attribute', fn ($a) => $a->where('slug', 'year'))
                    ->where('value', $request->year);
            });
        }

        if ($request->filled('model')) {
            $query->whereHas('attributeValues', function ($q) use ($request) {
                $q->whereHas('attribute', fn ($a) => $a->where('slug', 'model'))
                    ->where('value', $request->model);
            });
        }

        if ($request->filled('engine')) {
            $query->whereHas('attributeValues', function ($q) use ($request) {
                $q->whereHas('attribute', fn ($a) => $a->where('slug', 'engine'))
                    ->where('value', $request->engine);
            });
        }

        // Battery specification filters
        $filterableAttrs = ['voltage', 'capacity', 'cca', 'battery_type', 'group_size', 'terminal_type', 'polarity'];
        foreach ($filterableAttrs as $attr) {
            if ($request->filled($attr)) {
                $values = (array) $request->$attr;
                $query->whereHas('attributeValues', function ($q) use ($attr, $values) {
                    $q->whereHas('attribute', fn ($a) => $a->where('slug', $attr))
                        ->whereIn('value', $values);
                });
            }
        }

        $products = $query->orderBy('price', 'asc')->paginate(12)->withQueryString();

        // Get available filter values based on current selection
        $makes = VehicleMake::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name')
            ->toArray();
        $years = $this->getUniqueValues('year');
        $models = $this->getUniqueValues('model');
        $engines = $this->getUniqueValues('engine');

        return view('battery-finder.results', compact(
            'products',
            'makes',
            'years',
            'models',
            'engines',
            'request'
        ));
    }

public function getModels(Request $request)
    {
        $content = $request->getContent();
        $parsed = json_decode($content, true);
        \Log::info('getModels raw', ['content' => $content, 'parsed' => $parsed, 'input' => $request->input('make'), 'json' => $request->json('make')]);
        
        $make = $request->input('make') ?? $request->json('make') ?? $parsed['make'] ?? null;
        
        // Get models from BOTH vehicle_make relationship AND attribute-based lookup
        // This ensures compatibility with both new products (with vehicle_make_id) and legacy products (with attribute values)
        
        $vehicleMake = VehicleMake::where('name', $make)->first();
        
        $modelsFromAttribute = ProductAttributeValue::whereHas('attribute', fn ($q) => $q->where('slug', 'model'))
            ->whereHas('product.attributeValues', function ($q) use ($make) {
                $q->whereHas('attribute', fn ($a) => $a->where('slug', 'make'))
                    ->where('value', $make);
            })
            ->distinct()
            ->pluck('value')
            ->filter()
            ->sort()
            ->values();
        
        $modelsFromVehicleMake = collect();
        
        if ($vehicleMake) {
            $modelsFromVehicleMake = Product::where('vehicle_make_id', $vehicleMake->id)
                ->whereHas('attributeValues', fn ($q) => $q->whereHas('attribute', fn ($a) => $a->where('slug', 'model')))
                ->with('attributeValues')
                ->get()
                ->flatMap(function ($product) {
                    return $product->attributeValues
                        ->where('attribute.slug', 'model')
                        ->pluck('value');
                })
                ->filter()
                ->unique()
                ->sort()
                ->values();
        }

        // Merge both collections, remove duplicates
        $models = $modelsFromAttribute->merge($modelsFromVehicleMake)
            ->unique()
            ->sort()
            ->values();

        return response()->json(['models' => $models]);
    }

    public function getEngines(Request $request)
    {
        $model = $request->input('model') ?? $request->json('model') ?? json_decode($request->getContent(), true)['model'] ?? null;

        $engines = ProductAttributeValue::whereHas('attribute', fn ($q) => $q->where('slug', 'engine'))
            ->whereHas('product.attributeValues', function ($q) use ($model) {
                $q->whereHas('attribute', fn ($a) => $a->where('slug', 'model'))
                    ->where('value', $model);
            })
            ->distinct()
            ->pluck('value')
            ->filter()
            ->sort()
            ->values();

        return response()->json(['engines' => $engines]);
    }

    private function getUniqueValues(string $attributeSlug): array
    {
        return ProductAttributeValue::whereHas('attribute', fn ($q) => $q->where('slug', $attributeSlug))
            ->distinct()
            ->pluck('value')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }
}