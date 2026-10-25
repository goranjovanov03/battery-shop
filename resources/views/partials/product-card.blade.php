<div class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-xl hover:border-amber-200 transition-all duration-300">
    <!-- Product Image -->
    <div class="relative aspect-square bg-gray-50 overflow-hidden">
        @if($product->main_image)
            <img src="{{ asset('storage/' . $product->main_image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @elseif($product->images->first())
            <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/>
                </svg>
            </div>
        @endif
        
        <!-- Badges -->
        <div class="absolute top-2 left-2 flex flex-col gap-1">
            @if($product->is_featured)
                <span class="bg-amber-500 text-white text-xs font-medium px-2 py-1 rounded">Featured</span>
            @endif
            @if($product->sale_price && $product->sale_price < $product->price)
                <span class="bg-red-500 text-white text-xs font-medium px-2 py-1 rounded">Sale</span>
            @endif
            @if($product->stock_quantity > 0 && $product->stock_quantity <= 5)
                <span class="bg-orange-500 text-white text-xs font-medium px-2 py-1 rounded">Low Stock</span>
            @endif
        </div>
        
        <!-- Quick Add to Cart -->
        <div class="absolute bottom-2 left-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <button data-add-to-cart="{{ $product->id }}" 
                    class="w-full bg-amber-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-amber-700 transition">
                Add to Cart
            </button>
        </div>
    </div>
    
    <!-- Product Info -->
    <div class="p-4">
        <div class="flex items-start justify-between mb-2">
            <div>
                @if($product->brand)
                    <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $product->brand->name }}</p>
                @endif
                <h3 class="font-semibold text-gray-900 line-clamp-1 mt-1">
                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-amber-600 transition">
                        {{ $product->name }}
                    </a>
                </h3>
            </div>
            @if($product->stock_quantity === 0)
                <span class="text-xs text-red-500 font-medium">Out of Stock</span>
            @elseif($product->stock_quantity <= 5)
                <span class="text-xs text-orange-500 font-medium">Only {{ $product->stock_quantity }} left</span>
            @endif
        </div>
        
        <!-- Key Specs -->
        <div class="flex flex-wrap gap-2 mb-3 text-xs text-gray-500">
            @foreach($product->attributeValues->take(3) as $attr)
                @if($attr->attribute && in_array($attr->attribute->slug, ['voltage', 'capacity', 'cca', 'group_size', 'battery_type']))
                    <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $attr->value }}{{ $attr->attribute->unit }}</span>
                @endif
            @endforeach
        </div>
        
        <!-- Price & Action -->
        <div class="flex items-center justify-between">
            <div>
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="text-2xl font-bold text-amber-600">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-gray-400 line-through text-sm ml-2">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            <a href="{{ route('products.show', $product->slug) }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                View Details →
            </a>
        </div>
    </div>
</div>