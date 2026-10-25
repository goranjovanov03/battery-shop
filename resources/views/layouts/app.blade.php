<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
</body>
</html>