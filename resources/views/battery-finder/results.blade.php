<x-layouts.app :title="__('common.battery_finder') . ' - ' . __('common.search_results')" :description="__('common.battery_finder') . ' - ' . __('common.search_results')">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back to Search -->
        <div class="mb-6">
            <a href="{{ route('battery-finder.index') }}" class="inline-flex items-center text-amber-600 hover:text-amber-700 font-medium">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('common.search') }}
            </a>
        </div>
        
        <!-- Vehicle Summary -->
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-3">{{ __('common.your_vehicle') }}</h2>
            <div class="flex flex-wrap gap-4 text-sm">
                @if($request->filled('make'))
                    <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full">
                        <strong>{{ __('common.make') }}:</strong> {{ $request->make }}
                    </span>
                @endif
                @if($request->filled('year'))
                    <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full">
                        <strong>{{ __('common.year') }}:</strong> {{ $request->year }}
                    </span>
                @endif
                @if($request->filled('model'))
                    <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full">
                        <strong>{{ __('common.model') }}:</strong> {{ $request->model }}
                    </span>
                @endif
                @if($request->filled('engine'))
                    <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full">
                        <strong>{{ __('common.engine') }}:</strong> {{ $request->engine }}
                    </span>
                @endif
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-6">
                    <!-- Battery Spec Filters -->
                    @if(isset($makes) && count($makes) > 0)
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">{{ __('common.make') }}</h3>
                            <ul class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($makes as $make)
                                    <li>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   name="make" 
                                                   value="{{ $make }}"
                                                   {{ $request->filled('make') && $request->make === $make ? 'checked' : '' }}
                                                   class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                                                   onchange="this.form.submit()">
                                            <span class="ml-2 text-sm text-gray-700">{{ $make }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(isset($years) && count($years) > 0)
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">{{ __('common.year') }}</h3>
                            <ul class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($years as $year)
                                    <li>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   name="year" 
                                                   value="{{ $year }}"
                                                   {{ $request->filled('year') && $request->year === (string)$year ? 'checked' : '' }}
                                                   class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                                                   onchange="this.form.submit()">
                                            <span class="ml-2 text-sm text-gray-700">{{ $year }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(isset($models) && count($models) > 0)
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">{{ __('common.model') }}</h3>
                            <ul class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($models as $model)
                                    <li>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   name="model" 
                                                   value="{{ $model }}"
                                                   {{ $request->filled('model') && $request->model === $model ? 'checked' : '' }}
                                                   class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                                                   onchange="this.form.submit()">
                                            <span class="ml-2 text-sm text-gray-700">{{ $model }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(isset($engines) && count($engines) > 0)
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">{{ __('common.engine') }}</h3>
                            <ul class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($engines as $engine)
                                    <li>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   name="engine" 
                                                   value="{{ $engine }}"
                                                   {{ $request->filled('engine') && $request->engine === $engine ? 'checked' : '' }}
                                                   class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                                                   onchange="this.form.submit()">
                                            <span class="ml-2 text-sm text-gray-700">{{ $engine }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Clear Filters -->
                    @if($request->filled('make') || $request->filled('year') || $request->filled('model') || $request->filled('engine'))
                        <a href="{{ route('battery-finder.index') }}" class="block w-full text-center text-amber-600 hover:text-amber-700 font-medium py-2 px-4 border border-amber-300 rounded-lg">
                            {{ __('common.clear_all_filters') }}
                        </a>
                    @endif
                </div>
            </aside>
            
            <!-- Results -->
            <main class="flex-1 min-w-0">
                <!-- Toolbar -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">{{ $products->total() }} {{ __('common.compatible_batteries') }}</span>
                        <select name="sort" 
                                onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>{{ __('common.price_low_high') }}</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('common.price_high_low') }}</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>{{ __('common.newest') }}</option>
                            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>{{ __('common.name_a_z') }}</option>
                        </select>
                    </div>
                </div>
                
                <!-- Products -->
                @if($products->count() > 0)
                    <form method="GET" action="{{ route('battery-finder.search') }}">
                        @foreach($request->query() as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                            @foreach($products as $product)
                                @include('partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex justify-center">
                            {{ $products->links() }}
                        </div>
                    </form>
                @else
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('common.no_products_found') }}</h3>
                        <p class="text-gray-500 mb-4">{{ __('common.adjust_filters') }}</p>
                        <a href="{{ route('battery-finder.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">{{ __('common.browse_all') }}</a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-layouts.app>