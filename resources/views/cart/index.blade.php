<x-layouts.app :title="'Shopping Cart'" :description="'Review your shopping cart at Battery Shop.'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>
        
        @if(count($cartItems) > 0)
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($cartItems as $id => $item)
                                        <tr class="hover:bg-gray-50" data-cart-item="{{ $id }}">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-16 h-16 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0">
                                                        @if($item['product']->main_image)
                                                            <img src="{{ asset('storage/' . $item['product']->main_image) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                                        @elseif($item['product']->images->first())
                                                            <img src="{{ asset('storage/' . $item['product']->images->first()->path) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/></svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h3 class="font-medium text-gray-900">
                                                            <a href="{{ route('products.show', $item['product']->slug) }}" class="hover:text-amber-600">{{ $item['product']->name }}</a>
                                                        </h3>
                                                        @if($item['product']->brand)
                                                            <p class="text-sm text-gray-500">{{ $item['product']->brand->name }}</p>
                                                        @endif
                                                        @if($item['product']->sku)
                                                            <p class="text-xs text-gray-400">SKU: {{ $item['product']->sku }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($item['product']->sale_price && $item['product']->sale_price < $item['product']->price)
                                                    <span class="text-amber-600 font-semibold">${{ number_format($item['product']->sale_price, 2) }}</span>
                                                    <span class="text-gray-400 line-through text-sm ml-2">${{ number_format($item['product']->price, 2) }}</span>
                                                @else
                                                    <span class="font-semibold text-gray-900">${{ number_format($item['product']->price, 2) }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-32">
                                                    <button type="button" onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" class="px-3 py-1 bg-gray-50 hover:bg-gray-100 text-gray-600" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>−</button>
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock_quantity }}" class="w-12 text-center border-x border-gray-300 focus:outline-none" onchange="updateQuantity({{ $id }}, this.value)">
                                                    <button type="button" onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" class="px-3 py-1 bg-gray-50 hover:bg-gray-100 text-gray-600" {{ $item['quantity'] >= $item['product']->stock_quantity ? 'disabled' : '' }}>+</button>
                                                </div>
                                                @if($item['product']->stock_quantity <= 5 && $item['product']->stock_quantity > 0)
                                                    <p class="text-xs text-orange-500 mt-1">Only {{ $item['product']->stock_quantity }} in stock</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-semibold text-gray-900">${{ number_format($item['total'], 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <button onclick="removeFromCart({{ $id }})" class="text-red-500 hover:text-red-700 text-sm font-medium">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Cart Actions -->
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-between">
                            <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">← Continue Shopping</a>
                            <button onclick="clearCart()" class="text-red-500 hover:text-red-700 font-medium">Clear Cart</button>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
                        
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Subtotal</dt>
                                <dd class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</dd>
                            </div>
                            
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Shipping</dt>
                                <dd class="font-medium text-gray-900">
                                    @if($subtotal >= 100)
                                        <span class="text-green-600">Free</span>
                                    @else
                        ${{ number_format($shipping, 2) }}
                                    @endif
                                </dd>
                            </div>
                            
                            @if($subtotal < 100)
                                <p class="text-xs text-amber-600 bg-amber-50 px-3 py-2 rounded">Add ${{ number_format(100 - $subtotal, 2) }} more for free shipping!</p>
                            @endif
                            
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Estimated Tax (10%)</dt>
                                <dd class="font-medium text-gray-900">${{ number_format($tax, 2) }}</dd>
                            </div>
                        </dl>
                        
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between text-lg font-bold">
                                <dt class="text-gray-900">Total</dt>
                                <dd class="text-gray-900">${{ number_format($total, 2) }}</dd>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="w-full mt-6 bg-amber-600 text-white py-3 px-6 rounded-lg font-semibold text-center block hover:bg-amber-700 transition">
                            Proceed to Checkout
                        </a>
                        
                        <div class="mt-4 text-center text-sm text-gray-500">
                            <p>Secure checkout • 30-day returns • Free shipping on $100+</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-6">Looks like you haven't added any batteries yet.</p>
                <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</x-layouts.app>

@push('scripts')
<script>
    function updateQuantity(productId, quantity) {
        quantity = parseInt(quantity);
        if (quantity < 1) return;
        
        fetch('{{ route('cart.update', ':id') }}'.replace(':id', productId), {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            }
        });
    }
    
    function removeFromCart(productId) {
        if (!confirm('Remove this item from your cart?')) return;
        
        fetch('{{ route('cart.remove', ':id') }}'.replace(':id', productId), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            }
        });
    }
    
    function clearCart() {
        if (!confirm('Clear all items from your cart?')) return;
        
        fetch('{{ route('cart.clear') }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            }
        });
    }
</script>
@endpush