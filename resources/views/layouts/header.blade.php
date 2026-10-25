<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    @php
    $siteLogo = \App\Models\Setting::getValue('site_logo');
    $siteName = \App\Models\Setting::getValue('site_name', config('app.name'));
@endphp
@if($siteLogo)
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="h-8 w-auto">
                    @else
                        <svg class="h-8 w-8 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/>
                        </svg>
                    @endif
                    <span class="ml-2 text-xl font-bold text-gray-900">{{ $siteName }}</span>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-8" aria-label="Main navigation">
                <x-menu-renderer location="header" cssClass="flex items-center space-x-4" :showDropdown="true" />
            </nav>
            
            <!-- Right side: Search, Cart, Account -->
            <div class="flex items-center space-x-4">
                <!-- Language (Macedonian only) -->
                <div class="flex items-center gap-1 p-2 text-gray-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 12.586V7a1 1 0 10-2 0v4.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 12.586V14z"/>
                    </svg>
                    <span class="hidden sm:block text-sm font-medium uppercase">MK</span>
                </div>
                
                <!-- Search -->
                <form action="{{ route('products.search') }}" method="GET" class="hidden sm:block relative">
                    <input type="text" name="q" placeholder="{{ __('common.search_batteries') }}" 
                           class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                           value="{{ request('q') }}">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>
                
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-amber-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-amber-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center hidden" data-cart-count>0</span>
                </a>
                
                <!-- Account -->
                @auth
                    <div class="relative" id="account-menu">
                        <button type="button"
                                class="flex items-center gap-2 p-2 text-gray-700 hover:text-amber-600 hover:bg-gray-100 rounded-lg transition"
                                onclick="toggleAccountMenu()"
                                aria-expanded="false"
                                aria-haspopup="true">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 hidden"
                             id="account-dropdown"
                             role="menu"
                             aria-orientation="vertical">
                            <a href="{{ route('account.index') }}"
                               class="block px-4 py-2 text-gray-700 hover:text-amber-600 hover:bg-gray-50 transition"
                               role="menuitem">
                                {{ __('common.my_account') }}
                            </a>
                            @if(auth()->user()->email === 'admin@batteryshop.com')
                                <a href="{{ route('admin.index') }}"
                                   class="block px-4 py-2 text-gray-700 hover:text-amber-600 hover:bg-gray-50 transition"
                                   role="menuitem">
                                    {{ __('common.admin_panel') }}
                                </a>
                            @endif
                            <hr class="my-1 border-gray-200">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 transition"
                                        role="menuitem">
                                    {{ __('common.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-amber-600 transition">{{ __('common.login') }}</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition">{{ __('common.register') }}</a>
                @endauth
            </div>
        </div>
        
        <!-- Mobile menu would go here -->
    </div>
</header>

<script>
    // Language dropdown removed - Macedonian only
</script>