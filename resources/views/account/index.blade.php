<x-layouts.app title="My Account">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Account</h1>
            <p class="text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <aside class="md:col-span-1">
                <nav class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Menu</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('account.index') }}"
                               class="block px-4 py-2 text-amber-600 font-medium bg-amber-50 rounded-lg">
                                Order History
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="block px-4 py-2 text-gray-700 hover:text-amber-600 hover:bg-gray-50 rounded-lg transition">
                                Address Book
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="block px-4 py-2 text-gray-700 hover:text-amber-600 hover:bg-gray-50 rounded-lg transition">
                                Account Settings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               class="block px-4 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Order History</h2>
                    </div>

                    @if($orders->isEmpty())
                        <div class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No orders yet</h3>
                            <p class="mt-1 text-gray-500">When you place an order, it will appear here.</p>
                            <a href="{{ route('products.index') }}"
                               class="mt-4 inline-block px-4 py-2 text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition">
                                Start Shopping
                            </a>
                        </div>
                    @else
                        <div class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <div class="px-6 py-4 hover:bg-gray-50 transition">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <p class="font-medium text-gray-900">Order #{{ $order->id }}</p>
                                                <p class="text-sm text-gray-500">{{ $order->created_at->format('F j, Y') }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>

                                            <span class="font-semibold text-gray-900">${{ number_format($order->total, 2) }}</span>

                                            <a href="{{ route('account.orders.show', $order) }}"
                                               class="text-amber-600 hover:text-amber-700 font-medium text-sm transition">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</x-layouts.app>