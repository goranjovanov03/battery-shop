<x-layouts.app :title="__('common.shop_all')" :description="__('common.premium_every_vehicle')">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('common.shop_all') }}</h1>
            <p class="text-gray-600 mt-1">{{ $products->total() }} {{ __('common.products') }}</p>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-6">
                    <!-- Categories Filter -->
                    <div class="bg-white rounded-xl border border-gray-200 p-4">
                        <h3 class="font-semibold text-gray-900 mb-3">{{ __('common.categories') }}</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('products.index') }}" 
                                   class="block px-3 py-2 rounded-lg text-sm {{ !$selectedCategory ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                    {{ __('common.all_categories') }}
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('products.index', array_merge(request()->query(), ['category' => $category->slug])) }}" 
                                       class="block px-3 py-2 rounded-lg text-sm {{ $selectedCategory && $selectedCategory->slug === $category->slug ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                        {{ $category->name }}
                                    </a>
                                    @if($category->children->count() > 0)
                                        <ul class="ml-4 mt-1 space-y-1 border-l border-gray-200 pl-2">
                                            @foreach($category->children as $child)
                                                <li>
                                                    <a href="{{ route('products.index', array_merge(request()->query(), ['category' => $child->slug])) }}" 
                                                       class="block px-3 py-1.5 rounded-lg text-sm {{ $selectedCategory && $selectedCategory->slug === $child->slug ? 'bg-amber-50 text-amber-700' : 'text-gray-500 hover:bg-gray-50' }}">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Brand Filter -->
                    @if(isset($filters['brand']))
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">{{ __('common.brand') }}</h3>
                            <ul class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($filters['brand']['values'] as $brand)
                                    <li>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   name="brand" 
                                                   value="{{ $brand['slug'] }}"
                                                   {{ in_array($brand['slug'], $filters['brand']['selected'] ?? []) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $brand['name'] }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Price Filter -->
                    @if(isset($filters['price']))
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">{{ __('common.price_range') }}</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">{{ __('common.min') }}: ${{ number_format($filters['price']['selected_min'] ?? $filters['price']['min'], 2) }}</label>
                                    <input type="range" 
                                           name="min_price" 
                                           min="{{ $filters['price']['min'] }}" 
                                           max="{{ $filters['price']['max'] }}" 
                                           value="{{ $filters['price']['selected_min'] ?? $filters['price']['min'] }}"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-amber-600">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">{{ __('common.max') }}: ${{ number_format($filters['price']['selected_max'] ?? $filters['price']['max'], 2) }}</label>
                                    <input type="range" 
                                           name="max_price" 
                                           min="{{ $filters['price']['min'] }}" 
                                           max="{{ $filters['price']['max'] }}" 
                                           value="{{ $filters['price']['selected_max'] ?? $filters['price']['max'] }}"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-amber-600">
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Attribute Filters -->
                    @foreach($filters as $key => $filter)
                        @if($key !== 'brand' && $key !== 'price')
                            <div class="bg-white rounded-xl border border-gray-200 p-4">
                                <h3 class="font-semibold text-gray-900 mb-3">{{ $filter['name'] }}{{ $filter['unit'] ? ' (' . $filter['unit'] . ')' : '' }}</h3>
                                <ul class="space-y-2 max-h-40 overflow-y-auto">
                                    @foreach($filter['values'] as $value)
                                        <li>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" 
                                                       name="attributes[{{ $key }}][]" 
                                                       value="{{ $value }}"
                                                       {{ in_array($value, $filter['selected'] ?? []) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                                <span class="ml-2 text-sm text-gray-700">{{ $value }}{{ $filter['unit'] ? ' ' . $filter['unit'] : '' }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                    
                    <!-- Clear Filters -->
                    @if($selectedCategory || $selectedBrand || $selectedAttributes || request('min_price') || request('max_price'))
                        <a href="{{ route('products.index') }}" class="block w-full text-center text-amber-600 hover:text-amber-700 font-medium py-2 px-4 border border-amber-300 rounded-lg">
                            {{ __('common.clear_all_filters') }}
                        </a>
                    @endif
                </div>
            </aside>
            
            <!-- Products Grid -->
            <main class="flex-1 min-w-0">
                <!-- Toolbar -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">{{ __('common.sort_by') }}:</span>
                        <select name="sort" 
                                onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>{{ __('common.newest') }}</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>{{ __('common.price_low_high') }}</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>{{ __('common.price_high_low') }}</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>{{ __('common.name_a_z') }}</option>
                            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>{{ __('common.name_z_a') }}</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">{{ __('common.show') }}:</span>
                        <select name="per_page" 
                                onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12</option>
                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                        </select>
                    </div>
                </div>
                
                <!-- Products -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8" id="products-grid">
                        @foreach($products as $product)
                            @include('partials.product-card', ['product' => $product])
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('common.no_products_found') }}</h3>
                        <p class="text-gray-500 mb-4">{{ __('common.adjust_filters') }}</p>
                        <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">{{ __('common.clear_filters') }}</a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-layouts.app>