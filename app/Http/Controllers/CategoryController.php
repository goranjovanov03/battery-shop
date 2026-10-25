<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category, Request $request)
    {
        $category->load(['children', 'parent']);

        $categoryIds = $category->descendants->pluck('id')->push($category->id);

        $query = Product::with(['brand', 'category', 'images', 'attributeValues.attribute'])
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds);

        // Filter by brand
        $selectedBrand = null;
        if ($request->has('brand')) {
            $selectedBrand = Brand::where('slug', $request->brand)->first();
            if ($selectedBrand) {
                $query->where('brand_id', $selectedBrand->id);
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

        // Get available filters for this category
        $filters = $this->getCategoryFilters($categoryIds, $request, $selectedBrand, $selectedAttributes);

        // Breadcrumbs
        $breadcrumbs = $this->buildBreadcrumbs($category);

        return view('categories.show', compact(
            'category',
            'products',
            'filters',
            'selectedBrand',
            'selectedAttributes',
            'sort',
            'breadcrumbs'
        ));
    }

    private function getCategoryFilters(array $categoryIds, Request $request, $selectedBrand, $selectedAttributes): array
    {
        $baseQuery = Product::query()
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds);

        if ($selectedBrand) {
            $baseQuery->where('brand_id', $selectedBrand->id);
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
                'selected' => $selectedBrand ? [$selectedBrand->slug] : [],
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
                'selected_min' => $request->get('min_price'),
                'selected_max' => $request->get('max_price'),
            ];
        }

        return $filters;
    }

    private function buildBreadcrumbs(Category $category): array
    {
        $breadcrumbs = [];
        $current = $category;

        while ($current) {
            array_unshift($breadcrumbs, [
                'name' => $current->name,
                'slug' => $current->slug,
                'url' => route('categories.show', $current->slug),
            ]);
            $current = $current->parent;
        }

        array_unshift($breadcrumbs, [
            'name' => 'Categories',
            'slug' => null,
            'url' => route('categories.index'),
        ]);

        return $breadcrumbs;
    }
}
