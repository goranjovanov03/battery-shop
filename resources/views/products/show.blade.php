<x-layouts.app :title="$product->name" :description="$product->short_description ?? __('common.view_details') . ' ' . $product->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-amber-600">{{ __('common.home') }}</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="{{ route('products.index') }}" class="text-gray-500 hover:text-amber-600">{{ __('common.shop_all') }}</a></li>
                <li class="text-gray-400">/</li>
                @if($product->category)
                    <li><a href="{{ route('categories.show', $product->category->slug) }}" class="text-gray-500 hover:text-amber-600">{{ $product->category->name }}</a></li>
                    <li class="text-gray-400">/</li>
                @endif
                <li class="text-gray-900 font-medium truncate">{{ $product->name }}</li>
            </ol>
        </nav>
        
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Product Gallery -->
            <div class="lg:sticky lg:top-24 lg:self-start">
                <div class="space-y-3">
                    <!-- Main Image -->
                    <div class="relative aspect-square bg-gray-50 rounded-xl overflow-hidden">
                        @if($product->main_image)
                            <img src="{{ asset('storage/' . $product->main_image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover" id="main-image">
                        @elseif($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover" id="main-image">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/>
                                </svg>
                            </div>
                        @endif
                        
                        @if($product->is_featured)
                            <span class="absolute top-3 left-3 bg-amber-500 text-white text-xs font-medium px-2 py-1 rounded">{{ __('common.featured') }}</span>
                        @endif
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-medium px-2 py-1 rounded">{{ __('common.sale') }}</span>
                        @endif
                    </div>
                    
                    <!-- Thumbnails -->
                    @if($product->images->count() > 1)
                        <div class="flex gap-2 overflow-x-auto pb-2">
                            @foreach($product->images as $index => $image)
                                <button onclick="document.getElementById('main-image').src='{{ asset('storage/' . $image->path) }}'" 
                                        class="flex-shrink-0 w-20 h-20 rounded-lg border-2 {{ $index === 0 ? 'border-amber-500' : 'border-transparent hover:border-gray-300' }} overflow-hidden transition"
                                        aria-label="View image {{ $index + 1 }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }} - Image {{ $index + 1 }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Product Info -->
            <div>
                <!-- Brand & Category -->
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    @if($product->brand)
                        <a href="{{ route('brands.show', $product->brand->slug) }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">{{ $product->brand->name }}</a>
                    @endif
                    @if($product->category)
                        <span class="text-gray-400">/</span>
                        <a href="{{ route('categories.show', $product->category->slug) }}" class="text-sm text-gray-500 hover:text-amber-600">{{ $product->category->name }}</a>
                    @endif
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <!-- SKU & Stock -->
                <div class="flex flex-wrap items-center gap-4 mb-4 text-sm">
                    <span class="text-gray-500">SKU: <span class="text-gray-900 font-mono">{{ $product->sku }}</span></span>
                    @if($product->stock_quantity === 0)
                        <span class="text-red-500 font-medium">{{ __('common.out_of_stock') }}</span>
                    @elseif($product->stock_quantity <= 5)
                        <span class="text-orange-500 font-medium">{{ __('common.only_left', ['count' => $product->stock_quantity]) }}</span>
                    @else
                        <span class="text-green-600 font-medium">{{ __('common.in_stock') }}</span>
                    @endif
                </div>
                
                <!-- Rating Placeholder -->
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">(0 {{ __('common.reviews') }})</span>
                </div>
                
                <!-- Price -->
                <div class="mb-6">
                    @if($product->sale_price && $product->sale_price < $product->price)
                        <span class="text-3xl font-bold text-amber-600">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-gray-400 line-through text-xl ml-3">${{ number_format($product->price, 2) }}</span>
                        <span class="bg-red-500 text-white text-xs font-medium px-2 py-0.5 rounded ml-3">Save {{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%</span>
                    @else
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                    @if($product->warranty)
                        <p class="text-sm text-gray-500 mt-1">{{ $product->warranty }} {{ __('common.warranty') }}</p>
                    @endif
                </div>
                
                <!-- Short Description -->
                @if($product->short_description)
                    <div class="prose prose-sm text-gray-600 mb-6 border-t border-b border-gray-200 py-4">
                        {{ $product->short_description }}
                    </div>
                @endif
                
                <!-- Key Specifications -->
                @if($product->attributeValues->count() > 0)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">{{ __('common.key_specifications') }}</h3>
                        <div class="grid grid-cols-2 gap-3 bg-gray-50 rounded-xl p-4">
                            @foreach($product->attributeValues as $attr)
                                @if($attr->attribute && in_array($attr->attribute->slug, ['voltage', 'capacity', 'cca', 'group_size', 'battery_type', 'terminal_type', 'warranty_months']))
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $attr->attribute->name }}</p>
                                        <p class="font-medium text-gray-900">{{ $attr->value }}{{ $attr->attribute->unit ? ' ' . $attr->attribute->unit : '' }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Add to Cart -->
                @if($product->stock_quantity > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <button type="button" onclick="this.parentNode.querySelector('input').stepDown()" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-16 text-center border-x border-gray-300 focus:outline-none">
                                <button type="button" onclick="this.parentNode.querySelector('input').stepUp()" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600">+</button>
                            </div>
                            <button type="submit" data-add-to-cart="{{ $product->id }}" class="flex-1 bg-amber-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-amber-700 transition">
                                {{ __('common.add_to_cart') }}
                            </button>
                        </div>
                    </form>
                @else
                    <button disabled class="w-full bg-gray-300 text-gray-500 py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                        {{ __('common.out_of_stock') }}
                    </button>
                @endif
                
                <!-- Trust Badges -->
                <div class="flex flex-wrap gap-4 pt-6 border-t border-gray-200">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        {{ __('common.secure_checkout') }}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        {{ __('common.easy_returns') }}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-2h14a2 2 0 110 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        {{ __('common.free_shipping') }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabs -->
        <div class="mt-12">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button data-tab="description" class="tab-btn py-4 px-1 border-b-2 border-amber-500 font-medium text-amber-600 text-sm">{{ __('common.description') }}</button>
                    <button data-tab="specifications" class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 text-sm">{{ __('common.specifications') }}</button>
                    @if($product->warranty)
                        <button data-tab="warranty" class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 text-sm">{{ __('common.warranty') }}</button>
                    @endif
                </nav>
            </div>
            
            <!-- Description Tab -->
            <div id="tab-description" class="tab-content py-8">
                @if($product->description)
                    <div class="prose prose-lg max-w-none">
                        {{ $product->description }}
                    </div>
                @else
                    <p class="text-gray-500">{{ __('common.no_description') }}</p>
                @endif
            </div>
            
            <!-- Specifications Tab -->
            <div id="tab-specifications" class="tab-content py-8 hidden">
                @if($product->attributeValues->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('common.specification') }}</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('common.value') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($product->attributeValues->sortBy(fn($a) => $a->attribute->sort_order ?? 999) as $attr)
                                    @if($attr->attribute)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ $attr->attribute->name }}{{ $attr->attribute->unit ? ' (' . $attr->attribute->unit . ')' : '' }}</td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $attr->value }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">{{ __('common.no_specifications') }}</p>
                @endif
            </div>
            
            <!-- Warranty Tab -->
            @if($product->warranty)
                <div id="tab-warranty" class="tab-content py-8 hidden">
                    <div class="prose prose-sm max-w-none">
                        <h3>{{ $product->warranty }} {{ __('common.limited_warranty') }}</h3>
                        <p>{{ __('common.warranty_desc', ['warranty' => $product->warranty]) }}</p>
                        <h4>{{ __('common.whats_covered') }}</h4>
                        <ul>
                            <li>{{ __('common.defects_materials') }}</li>
                            <li>{{ __('common.premature_capacity_loss') }}</li>
                            <li>{{ __('common.internal_short_circuits') }}</li>
                        </ul>
                        <h4>{{ __('common.whats_not_covered') }}</h4>
                        <ul>
                            <li>{{ __('common.improper_installation') }}</li>
                            <li>{{ __('common.overcharging_undercharging') }}</li>
                            <li>{{ __('common.physical_damage_misuse') }}</li>
                            <li>{{ __('common.normal_wear_tear') }}</li>
                        </ul>
                        <p>{{ __('common.warranty_claims') }}</p>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('common.related_products') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        @include('partials.product-card', ['product' => $related])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>

@push('scripts')
<script>
    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('border-amber-500', 'text-amber-600');
                b.classList.add('border-transparent', 'text-gray-500');
            });
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            
            btn.classList.remove('border-transparent', 'text-gray-500');
            btn.classList.add('border-amber-500', 'text-amber-600');
            document.getElementById('tab-' + btn.dataset.tab).classList.remove('hidden');
        });
    });
</script>
@endpush