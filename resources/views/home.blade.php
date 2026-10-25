<x-layouts.app :title="__('common.home')" :description="__('common.premium_every_vehicle')">
    {{-- Hero Slider Section --}}
    @php
        $heroSection = $homepageSections->firstWhere('type', 'hero');
        $categoriesSection = $homepageSections->firstWhere('type', 'categories');
        $productsSection = $homepageSections->firstWhere('type', 'products');
        $brandsSection = $homepageSections->firstWhere('type', 'brands');
        $arrivalsSection = $homepageSections->firstWhere('type', 'arrivals');
        $ctaSection = $homepageSections->firstWhere('type', 'cta');
    @endphp

    {{-- Hero Slider Section --}}
    @if($heroSection && $heroSection->is_active)
        <section class="relative">
            @if($heroSlides->isNotEmpty())
                <div class="hero-slider relative w-full overflow-hidden" data-autoplay="true" data-interval="5000">
                    <div class="slider-track flex transition-transform duration-700 ease-out">
                        @foreach($heroSlides as $index => $slide)
                            <div class="slide min-w-full relative" style="background-color: {{ $slide->background_color ?? '#1a1a2e' }}">
                                @if($slide->image)
                                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('storage/' . $slide->image) }}'); opacity: 0.3;"></div>
                                @endif
                                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32">
                                    <div class="max-w-3xl">
                                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                                            {{ $slide->title }}
                                        </h1>
                                        @if($slide->subtitle)
                                            <p class="text-lg sm:text-xl text-gray-300 mb-8 leading-relaxed">
                                                {{ $slide->subtitle }}
                                            </p>
                                        @endif
                                        @if($slide->button_text && $slide->button_link)
                                            <div class="flex flex-wrap gap-4">
                                                <a href="{{ $slide->button_link }}" class="px-8 py-3 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition">
                                                    {{ $slide->button_text }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Slider JavaScript --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const slider = document.querySelector('.hero-slider');
                            if (!slider) return;

                            const track = slider.querySelector('.slider-track');
                            const slides = slider.querySelectorAll('.slide');
                            const prevBtn = slider.querySelector('.slider-prev');
                            const nextBtn = slider.querySelector('.slider-next');
                            const dots = slider.querySelectorAll('.slider-dot');
                            
                            let currentIndex = 0;
                            const slideCount = slides.length;
                            let autoplayInterval;

                            // Hide navigation elements as requested
                            if (prevBtn) prevBtn.style.display = 'none';
                            if (nextBtn) nextBtn.style.display = 'none';
                            const dotsContainer = slider.querySelector('.slider-dots');
                            if (dotsContainer) dotsContainer.style.display = 'none';

                            function goToSlide(index) {
                                if (index < 0) index = slideCount - 1;
                                if (index >= slideCount) index = 0;
                                
                                currentIndex = index;
                                track.style.transform = `translateX(-${index * 100}%)`;
                                
                                // Update dots
                                dots.forEach((dot, i) => {
                                    dot.classList.toggle('bg-white', i === index);
                                    dot.classList.toggle('bg-white/50', i !== index);
                                });
                            }

                            function nextSlide() {
                                goToSlide(currentIndex + 1);
                            }

                            function prevSlide() {
                                goToSlide(currentIndex - 1);
                            }

                            // Autoplay
                            function startAutoplay() {
                                autoplayInterval = setInterval(nextSlide, 5000);
                            }

                            function stopAutoplay() {
                                clearInterval(autoplayInterval);
                            }

                            // Start autoplay
                            startAutoplay();

                            // Pause on hover
                            slider.addEventListener('mouseenter', stopAutoplay);
                            slider.addEventListener('mouseleave', startAutoplay);

                            // Dot navigation (still functional even if hidden)
                            dots.forEach((dot, index) => {
                                dot.addEventListener('click', () => {
                                    goToSlide(index);
                                    stopAutoplay();
                                    startAutoplay();
                                });
                            });

                            // Keyboard navigation
                            document.addEventListener('keydown', (e) => {
                                if (e.key === 'ArrowLeft') {
                                    prevSlide();
                                    stopAutoplay();
                                    startAutoplay();
                                } else if (e.key === 'ArrowRight') {
                                    nextSlide();
                                    stopAutoplay();
                                    startAutoplay();
                                }
                            });

                            // Touch swipe support
                            let touchStartX = 0;
                            let touchEndX = 0;

                            slider.addEventListener('touchstart', (e) => {
                                touchStartX = e.changedTouches[0].screenX;
                            }, { passive: true });

                            slider.addEventListener('touchend', (e) => {
                                touchEndX = e.changedTouches[0].screenX;
                                handleSwipe();
                            }, { passive: true });

                            function handleSwipe() {
                                const swipeThreshold = 50;
                                const diff = touchStartX - touchEndX;
                                
                                if (Math.abs(diff) > swipeThreshold) {
                                    if (diff > 0) {
                                        nextSlide();
                                    } else {
                                        prevSlide();
                                    }
                                    stopAutoplay();
                                    startAutoplay();
                                }
                            }
                        });
                    </script>
            @else
                {{-- Fallback Hero --}}
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                            {{ __('common.find_your_battery') }}
                        </h1>
                        <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ __('common.enter_vehicle_details') }}</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('products.index') }}" class="px-8 py-3 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition">
                                {{ __('common.shop_batteries') }}
                            </a>
                            <a href="{{ route('battery-finder.index') }}" class="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-gray-900 transition">
                                {{ __('common.find_my_battery') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    @endif

    {{-- Trust Indicators Section --}}
    @if($heroSection && isset($heroSection->content['show_trust_indicators']) && $heroSection->content['show_trust_indicators'])
    <section class="py-12 bg-white border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @if(isset($heroSection->content['trust_indicators']))
                    @foreach($heroSection->content['trust_indicators'] as $indicator)
                        <div>
                            <svg class="w-10 h-10 text-amber-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $indicator['icon'] ?? 'M5 8h14M5 8a2 2 0 110-2h14a2 2 0 110 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4' }}"/>
                            </svg>
                            <p class="font-semibold text-gray-900">{{ $indicator['title'] ?? '' }}</p>
                            <p class="text-sm text-gray-500">{{ $indicator['subtitle'] ?? '' }}</p>
                        </div>
                    @endforeach
                @else
                    {{-- Default indicators --}}
                    <div>
                        <svg class="w-10 h-10 text-amber-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-2h14a2 2 0 110 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <p class="font-semibold text-gray-900">{{ __('common.free_shipping_short') }}</p>
                        <p class="text-sm text-gray-500">{{ __('common.on_orders_over') }}</p>
                    </div>
                    <div>
                        <svg class="w-10 h-10 text-amber-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <p class="font-semibold text-gray-900">{{ __('common.secure_payment') }}</p>
                        <p class="text-sm text-gray-500">{{ __('common.protected_checkout') }}</p>
                    </div>
                    <div>
                        <svg class="w-10 h-10 text-amber-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <p class="font-semibold text-gray-900">{{ __('common.easy_returns_short') }}</p>
                        <p class="text-sm text-gray-500">{{ __('common.return_policy') }}</p>
                    </div>
                    <div>
                        <svg class="w-10 h-10 text-amber-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <p class="font-semibold text-gray-900">{{ __('common.expert_support_short') }}</p>
                        <p class="text-sm text-gray-500">{{ __('common.support_hours') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- Featured Categories Section --}}
    @if($categoriesSection && $categoriesSection->is_active)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-bold text-gray-900">{{ $categoriesSection->title ?? __('common.shop_by_category') }}</h2>
                <a href="{{ route('categories.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">{{ __('common.view_all') }}</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group relative aspect-square rounded-xl overflow-hidden bg-gray-100">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-semibold text-lg">{{ $category->name }}</h3>
                            <p class="text-white/80 text-sm">{{ $category->children->count() }} {{ __('common.subcategories') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Featured Products Section --}}
    @if($productsSection && $productsSection->is_active)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-bold text-gray-900">{{ $productsSection->title ?? __('common.featured_products') }}</h2>
                <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">{{ __('common.view_all') }}</a>
            </div>
            
            @if($featuredProducts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredProducts as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">{{ __('common.no_featured_products') }}</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- Top Brands Section --}}
    @if($brandsSection && $brandsSection->is_active)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-bold text-gray-900">{{ $brandsSection->title ?? __('common.trusted_brands') }}</h2>
                <a href="{{ route('brands.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">{{ __('common.view_all') }}</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4">
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
    </section>
    @endif

    {{-- New Arrivals Section --}}
    @if($arrivalsSection && $arrivalsSection->is_active)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-bold text-gray-900">{{ $arrivalsSection->title ?? __('common.new_arrivals') }}</h2>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="text-amber-600 hover:text-amber-700 font-medium">{{ __('common.view_all') }}</a>
            </div>
            
            @if($newArrivals->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($newArrivals as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">{{ __('common.no_new_arrivals') }}</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- CTA Section --}}
    @if($ctaSection && $ctaSection->is_active)
    <section class="py-16 bg-amber-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold mb-4">{{ $ctaSection->title ?? __('common.cant_find_battery') }}</h2>
            <p class="text-xl text-amber-100 mb-8 max-w-2xl mx-auto">
                {{ $ctaSection->content['description'] ?? __('common.use_battery_finder_desc') }}
            </p>
            @if(isset($ctaSection->content['button_text']) && isset($ctaSection->content['button_link']))
                <a href="{{ $ctaSection->content['button_link'] }}" class="inline-block px-8 py-3 bg-white text-amber-600 font-semibold rounded-lg hover:bg-amber-50 transition">
                    {{ $ctaSection->content['button_text'] }}
                </a>
            @else
                <a href="{{ route('battery-finder.index') }}" class="inline-block px-8 py-3 bg-white text-amber-600 font-semibold rounded-lg hover:bg-amber-50 transition">
                    {{ __('common.start_battery_finder') }}
                </a>
            @endif
        </div>
    </section>
    @endif
</x-layouts.app>