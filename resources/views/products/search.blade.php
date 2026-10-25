<x-layouts.app :title="'Search Results for \"' . $query . '\"'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Search Results</h1>
            <p class="text-gray-600 mt-1">{{ $products->total() }} results for "{{ $query }}"</p>
        </div>
        
        <!-- Search Form -->
        <form action="{{ route('products.search') }}" method="GET" class="mb-8">
            <div class="flex gap-4">
                <input type="text" name="q" value="{{ $query }}" 
                       placeholder="Search batteries..." 
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                <button type="submit" class="px-6 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition">
                    Search
                </button>
            </div>
        </form>
        
        <!-- Results -->
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No results found</h3>
                <p class="text-gray-500 mb-4">We couldn't find any batteries matching "{{ $query }}"</p>
                <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">Browse all batteries</a>
            </div>
        @endif
    </div>
</x-layouts.app>