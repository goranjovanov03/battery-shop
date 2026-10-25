<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('brands.index', compact('brands'));
    }

    public function show(Brand $brand, Request $request)
    {
        $query = Product::with(['brand', 'category', 'images', 'attributeValues.attribute'])
            ->where('is_active', true)
            ->where('brand_id', $brand->id);

        // Filter by category
        $selectedCategory = null;
        if ($request->has('category')) {
            $selectedCategory = Category::where('slug', $request->category)->first();
            if ($selectedCategory) {
                $categoryIds = $selectedCategory->descendants->pluck('id')->push($selectedCategory->id);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Filter by price
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by attributes
        $selectedAttributes = [];
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attributeSlug => $values) {
                $attribute = Attribute::where('slug', $attributeSlug)->first();
                if ($attribute && is_array($values)) {
                    $selectedAttributes[$attributeSlug] = $values;
                    $query->whereHas('attributeValues', function ($q) use ($attribute, $values) {
                        $q->where('attribute_id', $attribute->id)
                            ->whereIn('value', $values);
                    });
                }
            }
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage)->withQueryString();

        // Get available filters
        $filters = $this->getBrandFilters($brand->id, $request, $selectedCategory, $selectedAttributes);

        // All categories for filter sidebar
        $categories = Category::with('children')
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('brands.show', compact(
            'brand',
            'products',
            'categories',
            'filters',
            'selectedCategory',
            'selectedAttributes',
            'sort'
        ));
    }

    private function getBrandFilters(int $brandId, Request $request, $selectedCategory, $selectedAttributes): array
    {
        $baseQuery = Product::query()
            ->where('is_active', true)
            ->where('brand_id', $brandId);

        if ($selectedCategory) {
            $categoryIds = $selectedCategory->descendants->pluck('id')->push($selectedCategory->id);
            $baseQuery->whereIn('category_id', $categoryIds);
        }
        if ($request->has('min_price')) {
            $baseQuery->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $baseQuery->where('price', '<=', $request->max_price);
        }
        foreach ($selectedAttributes as $attributeSlug => $values) {
            $attribute = Attribute::where('slug', $attributeSlug)->first();
            if ($attribute) {
                $baseQuery->whereHas('attributeValues', function ($q) use ($attribute, $values) {
                    $q->where('attribute_id', $attribute->id)
                        ->whereIn('value', $values);
                });
            }
        }

        $filterableAttributes = Attribute::where('is_filterable', true)->get();
        $filters = [];

        foreach ($filterableAttributes as $attribute) {
            $values = $baseQuery->clone()
                ->join('product_attribute_values', 'products.id', '=', 'product_attribute_values.product_id')
                ->where('product_attribute_values.attribute_id', $attribute->id)
                ->distinct()
                ->pluck('product_attribute_values.value')
                ->filter()
                ->sort()
                ->values();

            if ($values->count() > 0) {
                $selected = $selectedAttributes[$attribute->slug] ?? [];
                $filters[$attribute->slug] = [
                    'name' => $attribute->name,
                    'unit' => $attribute->unit,
                    'type' => $attribute->type,
                    'values' => $values,
                    'selected' => $selected,
                ];
            }
        }

        $priceRange = $baseQuery->clone()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        if ($priceRange) {
            $filters['price'] = [
                'name' => 'Price',
                'unit' => '$',
                'type' => 'range',
                'min' => (float) $priceRange->min_price,
                'max' => (float) $priceRange->max_price,
                'selected_min' => $request->get('min_price'),
                'selected_max' => $request->get('max_price'),
            ];
        }

        return $filters;
    }
}
