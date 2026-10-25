<x-layouts.app :title="'Categories'" :description="'Browse our battery categories for cars, trucks, marine, RV, and more.'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Battery Categories</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="group relative aspect-[4/3] rounded-xl overflow-hidden bg-gray-100">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="text-white font-bold text-xl mb-1">{{ $category->name }}</h3>
                        <p class="text-white/80">{{ $category->children->count() }} subcategories</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.app>