<!DOCTYPE html>
<html {{ $attributes->merge(['lang' => str_replace('_', '-', app()->getLocale())]) }}>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Battery Shop' }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $description ?? 'Premium batteries for cars, trucks, marine, and more. Fast shipping, expert advice.' }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cart.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex flex-col min-h-screen">
        @include('layouts.header')
        
        <main class="flex-grow">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-4 mx-auto max-w-7xl" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-4 mx-auto max-w-7xl" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            
            {{ $slot }}
        </main>
        
        @include('layouts.footer')
    </div>
    
    @stack('scripts')

    {{ $scripts ?? '' }}
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Register Alpine components when Alpine initializes
        document.addEventListener('alpine:init', () => {
            Alpine.store('menu', {
                openDropdowns: [],
                toggleDropdown(dropdownId) {
                    if (this.openDropdowns.includes(dropdownId)) {
                        this.openDropdowns = this.openDropdowns.filter(i => i !== dropdownId);
                    } else {
                        // Close all other dropdowns first
                        this.openDropdowns = [dropdownId];
                    }
                },
                closeDropdown(dropdownId) {
                    this.openDropdowns = this.openDropdowns.filter(i => i !== dropdownId);
                },
                closeAllDropdowns() {
                    this.openDropdowns = [];
                },
            });

            Alpine.data('menuNavigation', () => ({
                init() {
                    // Ensure clean state on page load
                    $store.menu.openDropdowns = [];
                },
                '@toggle-dropdown.window'({ detail }) {
                    $store.menu.toggleDropdown(detail.dropdownId);
                },
                '@close-dropdown.window'({ detail }) {
                    $store.menu.closeDropdown(detail.dropdownId);
                },
                '@keydown-dropdown.window'({ detail }) {
                    if (detail.event.key === 'Escape') {
                        $store.menu.closeDropdown(detail.dropdownId);
                    }
                },
                closeAllDropdowns() {
                    $store.menu.closeAllDropdowns();
                },
            }));
        });
    </script>
</body>
</html>