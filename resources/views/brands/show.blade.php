<x-layouts.app :title="$brand->name" :description="Shop $brand->name batteries at Battery Shop. Free shipping on orders $100+.">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-amber-600">Home</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="{{ route('brands.index') }}" class="text-gray-500 hover:text-amber-600">Brands</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-medium">{{ $brand->name }}</li>
            </ol>
        </nav>
        
        <!-- Brand Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="h-24 w-auto object-contain">
                @else
                    <div class="h-24 w-auto flex items-center justify-center bg-amber-100 rounded-lg">
                        <svg class="w-16 h-16 text-amber-600" fill="currentColor" viewBox="0 0 24 24"><path d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/></svg>
                    </div>
                @endif
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $brand->name }}</h1>
                    @if($brand->description)
                        <p class="text-gray-600 mt-1">{{ $brand->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-6">
                    <!-- Category Filter -->
                    <div class="bg-white rounded-xl border border-gray-200 p-4">
                        <h3 class="font-semibold text-gray-900 mb-3">Category</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('brands.show', $brand->slug) }}" 
                                   class="block px-3 py-2 rounded-lg text-sm {{ !$selectedCategory ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                    All Categories
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('brands.show', array_merge(['brand' => $brand->slug], request()->query(), ['category' => $category->slug])) }}" 
                                       class="block px-3 py-2 rounded-lg text-sm {{ $selectedCategory && $selectedCategory->slug === $category->slug ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                        {{ $category->name }}
                                    </a>
                                    @if($category->children->count() > 0)
                                        <ul class="ml-4 mt-1 space-y-1 border-l border-gray-200 pl-2">
                                            @foreach($category->children as $child)
                                                <li>
                                                    <a href="{{ route('brands.show', array_merge(['brand' => $brand->slug], request()->query(), ['category' => $child->slug])) }}" 
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
                    
                    <!-- Price Filter -->
                    @if(isset($filters['price']))
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">Price</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Min: ${{ number_format($filters['price']['selected_min'] ?? $filters['price']['min'], 2) }}</label>
                                    <input type="range" 
                                           name="min_price" 
                                           min="{{ $filters['price']['min'] }}" 
                                           max="{{ $filters['price']['max'] }}" 
                                           value="{{ $filters['price']['selected_min'] ?? $filters['price']['min'] }}"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-amber-600">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Max: ${{ number_format($filters['price']['selected_max'] ?? $filters['price']['max'], 2) }}</label>
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
                        @if($key !== 'price')
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
                    @if($selectedCategory || $selectedAttributes || request('min_price') || request('max_price'))
                        <a href="{{ route('brands.show', $brand->slug) }}" class="block w-full text-center text-amber-600 hover:text-amber-700 font-medium py-2 px-4 border border-amber-300 rounded-lg">
                            Clear All Filters
                        </a>
                    @endif
                </div>
            </aside>
            
            <!-- Products Grid -->
            <main class="flex-1 min-w-0">
                <!-- Toolbar -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">{{ $products->total() }} products</span>
                        <select name="sort" 
                                onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Show:</span>
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No batteries from this brand</h3>
                        <p class="text-gray-500 mb-4">Try adjusting your filters</p>
                        <a href="{{ route('brands.show', $brand->slug) }}" class="text-amber-600 hover:text-amber-700 font-medium">Clear filters</a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-layouts.app>