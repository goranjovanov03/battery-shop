<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::with('children')
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function tree(): JsonResponse
    {
        $categories = Category::with('childrenRecursive')
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function show(Category $category): JsonResponse
    {
        $category->load(['children', 'parent']);

        return response()->json([
            'data' => $category,
        ]);
    }

    public function products(Category $category, Request $request): JsonResponse
    {
        $categoryIds = $category->descendants->pluck('id')->push($category->id);

        $query = Product::with(['brand', 'category', 'images', 'attributeValues.attribute'])
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds);

        // Filter by brand
        if ($request->has('brand')) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
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
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attributeSlug => $values) {
                $attribute = Attribute::where('slug', $attributeSlug)->first();
                if ($attribute && is_array($values)) {
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
        $products = $query->paginate($perPage);

        // Get available filters for this category
        $filters = $this->getCategoryFilters($categoryIds, $request);

        return response()->json([
            'data' => $products->items(),
            'category' => $category,
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
            'filters' => $filters,
        ]);
    }

    private function getCategoryFilters(array $categoryIds, Request $request): array
    {
        $baseQuery = Product::query()
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds);

        if ($request->has('brand')) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $baseQuery->where('brand_id', $brand->id);
            }
        }
        if ($request->has('min_price')) {
            $baseQuery->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $baseQuery->where('price', '<=', $request->max_price);
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
                $filters[$attribute->slug] = [
                    'name' => $attribute->name,
                    'unit' => $attribute->unit,
                    'type' => $attribute->type,
                    'values' => $values,
                ];
            }
        }

        $brands = $baseQuery->clone()
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('brands.is_active', true)
            ->distinct()
            ->pluck('brands.name', 'brands.slug')
            ->toArray();

        if (! empty($brands)) {
            $filters['brand'] = [
                'name' => 'Brand',
                'unit' => '',
                'type' => 'select',
                'values' => array_map(fn ($name, $slug) => ['slug' => $slug, 'name' => $name], $brands, array_keys($brands)),
            ];
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
            ];
        }

        return $filters;
    }
}
