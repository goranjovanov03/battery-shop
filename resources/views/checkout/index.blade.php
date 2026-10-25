<x-layouts.app :title="'Checkout'" :description="'Complete your purchase at Battery Shop. Secure checkout with multiple payment options.'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    
                    <!-- Contact Information -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Contact Information</h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" required
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" id="phone" required
                                       value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Shipping Address</h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" id="first_name" required
                                       value="{{ old('first_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" id="last_name" required
                                       value="{{ old('last_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                            <input type="text" name="address" id="address" required
                                   value="{{ old('address') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                   placeholder="Street address, P.O. box, company name, etc.">
                        </div>
                        
                        <div class="mt-4 grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                <input type="text" name="city" id="city" required
                                       value="{{ old('city') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province <span class="text-red-500">*</span></label>
                                <input type="text" name="state" id="state" required
                                       value="{{ old('state') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="mt-4 grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">ZIP/Postal Code <span class="text-red-500">*</span></label>
                                <input type="text" name="postal_code" id="postal_code" required
                                       value="{{ old('postal_code') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                                <select name="country" id="country" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <option value="USA" {{ old('country') === 'USA' ? 'selected' : '' }}>United States</option>
                                    <option value="CAN" {{ old('country') === 'CAN' ? 'selected' : '' }}>Canada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Notes -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Notes (Optional)</h2>
                        <textarea name="notes" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                  placeholder="Special instructions, delivery notes, etc.">{{ old('notes') }}</textarea>
                    </div>
                    
                    <!-- Place Order Button -->
                    <button type="submit" class="w-full bg-amber-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:bg-amber-700 transition">
                        Place Order - ${{ number_format($total, 2) }}
                    </button>
                    
                    <p class="text-center text-sm text-gray-500 mt-4">
                        By placing your order, you agree to our <a href="#" class="text-amber-600 hover:underline">Terms of Service</a> and <a href="#" class="text-amber-600 hover:underline">Privacy Policy</a>.
                    </p>
                </form>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $id => $item)
                            <div class="flex gap-3">
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
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $item['product']->name }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    <p class="font-semibold text-gray-900">${{ number_format($item['total'], 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <dl class="space-y-2 text-sm">
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
                            
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Tax (10%)</dt>
                                <dd class="font-medium text-gray-900">${{ number_format($tax, 2) }}</dd>
                            </div>
                        </dl>
                        
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <dt class="text-gray-900">Total</dt>
                                <dd class="text-gray-900">${{ number_format($total, 2) }}</dd>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Trust Badges -->
                    <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Secure SSL Encryption
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            30-Day Easy Returns
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-2h14a2 2 0 110 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            Free Shipping on $100+
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>