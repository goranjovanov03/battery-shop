<footer class="bg-gray-900 text-gray-400 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                @php
    $siteLogo = \App\Models\Setting::getValue('site_logo');
    $siteName = \App\Models\Setting::getValue('site_name', config('app.name'));
@endphp
<a href="{{ route('home') }}" class="flex items-center">
    @if($siteLogo)
        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="h-8 w-auto">
    @else
        <svg class="h-8 w-8 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14.4 3.6L12 6l-2.4-2.4C8.4 2.4 7.2 3.6 7.2 4.8v14.4c0 1.2 1.2 2.4 2.4 2.4h9.6c1.2 0 2.4-1.2 2.4-2.4V4.8c0-1.2-1.2-2.4-2.4-2.4zM10 5.2h4v1.6h-4V5.2zm0 3.2h4v8h-4v-8zm4.8 0h4v8h-4v-8z"/>
        </svg>
    @endif
    <span class="ml-2 text-xl font-bold text-white">{{ $siteName }}</span>
</a>
                <p class="mt-4 text-sm">Premium batteries for every vehicle. Fast shipping, expert advice, and the best warranty in the industry.</p>
            </div>
            
            <!-- Shop Links -->
            <div>
                <h3 class="text-white font-semibold mb-4">Shop</h3>
                <x-menu-renderer location="footer-shop" cssClass="space-y-2 text-sm" :showDropdown="false" orientation="vertical" />
            </div>
            
            <!-- Help Links -->
            <div>
                <h3 class="text-white font-semibold mb-4">Help</h3>
                <x-menu-renderer location="footer-help" cssClass="space-y-2 text-sm" :showDropdown="false" orientation="vertical" />
            </div>
            
            <!-- Contact Info -->
            <div>
                <h3 class="text-white font-semibold mb-4">Contact</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>hello@batteryshop.com</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>1-800-BATTERY</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>123 Battery St, Power City, PC 12345</span>
                    </li>
                </ul>
                
                <!-- Social -->
                <div class="mt-6 flex space-x-4">
                    @php
                        $facebookUrl = \App\Models\Setting::getValue('social_facebook_url', '#');
                        $facebookEnabled = \App\Models\Setting::getValue('social_facebook_enabled', true);
                        $instagramUrl = \App\Models\Setting::getValue('social_instagram_url', '#');
                        $instagramEnabled = \App\Models\Setting::getValue('social_instagram_enabled', true);
                        $whatsappUrl = \App\Models\Setting::getValue('social_whatsapp_url', '#');
                        $whatsappEnabled = \App\Models\Setting::getValue('social_whatsapp_enabled', true);
                    @endphp
                    
                    @if($facebookEnabled)
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-amber-400 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                    
                    @if($instagramEnabled)
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-amber-400 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                    @endif
                    
                    @if($whatsappEnabled)
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-amber-400 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.52 3.48A11.914 11.914 0 0012 0C5.373 0 0 5.373 0 12c0 2.366.707 4.572 1.878 6.486L0 24l6.305-1.654A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12 0-1.987-.517-3.86-1.37-5.48a8.083 8.083 0 00-.125-1.745 8.053 8.053 0 00-1.987-1.872A8.132 8.132 0 0020.52 3.48zM10.138 19.074c-.224 0-.44-.023-.652-.067l-3.706.982.984-3.722c-.044-.208-.067-.424-.067-.647 0-3.091 2.51-5.6 5.6-5.6.882 0 1.717.209 2.478.581.267.13.554.197.857.197.298 0 .59-.065.856-.193.754-.924 1.085-2.176.853-3.353-.271-1.382-1.26-2.506-2.642-2.506-1.878 0-3.4 1.962-2.97 3.54.316 1.133 1.241 2.04 2.36 2.461.07.027.14.04.21.04.278 0 .56-.125.75-.36.25-.31.375-.734.25-1.155-.12-.43-.51-.747-.954-.937-.46-.2-.95-.25-1.46-.17-.296.04-.596.108-.89.19-.583.162-1.15.284-1.703.284-.79 0-1.526-.267-2.137-.8-.928-.805-1.177-1.929-.93-3.04.33-1.482 1.63-2.633 3.114-2.633 1.207 0 2.253.477 3.012 1.268.885.92 1.44 2.048 1.69 3.247.04.175.06.352.06.53 0 3.091-2.51 5.6-5.6 5.6-.89 0-1.735-.214-2.48-.59z"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</footer>