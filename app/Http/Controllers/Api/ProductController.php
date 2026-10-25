<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query()
            ->with(['brand', 'category', 'images', 'attributeValues.attribute'])
            ->where('is_active', true);

        // Filter by category
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $categoryIds = $category->descendants->pluck('id')->push($category->id);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Filter by brand
        if ($request->has('brand')) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        // Filter by price range
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

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
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

        // Pagination
        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage);

        return response()->json([
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
            'filters' => $this->getAvailableFilters($request),
        ]);
    }

    public function featured(): JsonResponse
    {
        $products = Product::with(['brand', 'category', 'images'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return response()->json([
            'data' => $products,
        ]);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load([
            'brand',
            'category',
            'images',
            'attributeValues.attribute',
        ]);

        return response()->json([
            'data' => $product,
        ]);
    }

    public function related(Product $product): JsonResponse
    {
        $related = Product::with(['brand', 'category', 'images'])
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                    ->orWhere('brand_id', $product->brand_id);
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return response()->json([
            'data' => $related,
        ]);
    }

    private function getAvailableFilters(Request $request): array
    {
        $baseQuery = Product::query()->where('is_active', true);

        // Apply same filters except attributes to get accurate filter counts
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $categoryIds = $category->descendants->pluck('id')->push($category->id);
                $baseQuery->whereIn('category_id', $categoryIds);
            }
        }
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

        // Brands filter
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

        // Price range
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
