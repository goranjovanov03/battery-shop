<x-layouts.app :title="'Order Confirmed'" :description="'Your order has been confirmed. Thank you for shopping at Battery Shop.'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-2xl mx-auto text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
            <p class="text-lg text-gray-600 mb-8">Thank you for your order. We've sent a confirmation email to {{ $order->email }}.</p>
            
            <!-- Order Details -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 text-left mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Details</h2>
                
                <dl class="space-y-3 text-sm mb-6">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Order Number</dt>
                        <dd class="font-mono font-medium text-gray-900">#{{ $order->id }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Order Date</dt>
                        <dd class="font-medium text-gray-900">{{ $order->created_at->format('F d, Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Status</dt>
                        <dd class="font-medium text-amber-600">{{ ucfirst($order->status) }}</dd>
                    </div>
                </dl>
                
                <div class="border-t border-gray-200 pt-4 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Shipping Address</h3>
                    <address class="text-gray-600 not-italic">
                        {{ $order->first_name }} {{ $order->last_name }}<br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}<br>
                        {{ $order->country }}<br>
                        Phone: {{ $order->phone }}
                    </address>
                </div>
                
                <h3 class="font-semibold text-gray-900 mb-3">Items</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->product->name ?? 'Product' }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                            </div>
                            <span class="font-semibold text-gray-900">${{ number_format($item->total, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                
                <div class="border-t border-gray-200 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium text-gray-900">${{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium text-gray-900">${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-2">
                        <span class="text-gray-900">Total</span>
                        <span class="text-gray-900">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition">
                    Continue Shopping
                </a>
                <p class="text-sm text-gray-500">
                    Questions about your order? <a href="#" class="text-amber-600 hover:underline">Contact us</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>