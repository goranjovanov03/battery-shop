<x-layouts.app :title="'Brands'" :description="'Shop premium battery brands including Bosch, Varta, Optima, Odyssey, and more.'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Trusted Battery Brands</h1>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-12">
            @foreach($brands as $brand)
                <a href="{{ route('brands.show', $brand->slug) }}" class="group flex flex-col items-center p-6 bg-white rounded-xl border border-gray-200 hover:border-amber-300 hover:shadow-lg transition">
                    @if($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="h-16 w-auto object-contain mb-3 group-hover:scale-105 transition-transform">
                    @else
                        <div class="h-16 w-auto flex items-center justify-center mb-3 text-gray-300">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/></svg>
                        </div>
                    @endif
                    <span class="text-gray-700 font-medium text-center">{{ $brand->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.app>