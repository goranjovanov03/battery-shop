<x-layouts.app :title="__('common.battery_finder')" :description="__('common.enter_vehicle_details')">
    <x-slot:scripts>
        @push('scripts')
        <script>
            // Simple AJAX for dependent dropdowns
            function updateModels(make) {
                const modelSelect = document.getElementById('model');
                const engineSelect = document.getElementById('engine');
                
                modelSelect.disabled = !make;
                engineSelect.disabled = true;
                modelSelect.innerHTML = '<option value="">Loading...</option>';
                engineSelect.innerHTML = '<option value="">Select Model First</option>';
                
                if (!make) {
                    modelSelect.innerHTML = '<option value="">Select Make First</option>';
                    return;
                }
                
                // In a real app, you'd fetch models from an API endpoint
                // For now, we'll use the pre-loaded data
                const formData = new FormData();
                formData.append('make', make);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                
                fetch('{{ route('battery-finder.models') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    modelSelect.innerHTML = '<option value="">Select Model</option>';
                    data.models.forEach(model => {
                        const opt = document.createElement('option');
                        opt.value = model;
                        opt.textContent = model;
                        modelSelect.appendChild(opt);
                    });
                })
                .catch(() => {
                    modelSelect.innerHTML = '<option value="">Select Model</option>';
                });
            }
            
            // Update engines when model changes
            document.getElementById('model').addEventListener('change', function() {
                const engineSelect = document.getElementById('engine');
                const model = this.value;
                
                engineSelect.disabled = !model;
                engineSelect.innerHTML = '<option value="">Loading...</option>';
                
                if (!model) {
                    engineSelect.innerHTML = '<option value="">Select Model First</option>';
                    return;
                }
                
                const formData = new FormData();
                formData.append('model', model);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                
                fetch('{{ route('battery-finder.engines') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    engineSelect.innerHTML = '<option value="">Select Engine</option>';
                    data.engines.forEach(engine => {
                        const opt = document.createElement('option');
                        opt.value = engine;
                        opt.textContent = engine;
                        engineSelect.appendChild(opt);
                    });
                })
                .catch(() => {
                    engineSelect.innerHTML = '<option value="">Select Engine</option>';
                });
            });
        </script>
        @endpush
    </x-slot:scripts>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ __('common.find_your_battery') }}</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ __('common.enter_vehicle_details') }}</p>
        </div>
        
        <!-- Search Form -->
        <div class="max-w-3xl mx-auto bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
            <form method="POST" action="{{ route('battery-finder.search') }}" id="battery-finder-form">
                @csrf
                
                <!-- Vehicle Selection -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('common.vehicle_information') }}</h2>
                    
                    <div class="grid sm:grid-cols-2 gap-6">
                        <!-- Make -->
                        <div>
                            <label for="make" class="block text-sm font-medium text-gray-700 mb-2">{{ __('common.make') }} <span class="text-red-500">*</span></label>
                            <select name="make" id="make" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                    onchange="updateModels(this.value)">
                                <option value="">{{ __('common.select_make') }}</option>
                                @foreach($makes as $make)
                                    <option value="{{ $make }}">{{ $make }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Year -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-2">{{ __('common.year') }} <span class="text-red-500">*</span></label>
                            <select name="year" id="year" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                <option value="">{{ __('common.select_year') }}</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Model -->
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700 mb-2">{{ __('common.model') }} <span class="text-red-500">*</span></label>
                            <select name="model" id="model" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                    disabled>
                                <option value="">{{ __('common.select_model_first') }}</option>
                            </select>
                        </div>
                        
                        <!-- Engine -->
                        <div>
                            <label for="engine" class="block text-sm font-medium text-gray-700 mb-2">{{ __('common.engine') }} <span class="text-red-500">*</span></label>
                            <select name="engine" id="engine" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                    disabled>
                                <option value="">{{ __('common.select_engine_first') }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg font-semibold text-lg hover:bg-amber-700 transition">
                            {{ __('common.find_my_battery') }}
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Battery Specs Filters (Optional) -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('common.filter_by_specs') }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ __('common.refine_search') }}</p>
                
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($attributes->take(6) as $attribute)
                        @if($attribute->type === 'select' && $attribute->options)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ $attribute->name }}{{ $attribute->unit ? ' (' . $attribute->unit . ')' : '' }}</label>
                                <select name="{{ $attribute->slug }}[]" multiple
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm"
                                        size="4">
                                    @foreach($attribute->options as $option)
                                        <option value="{{ $option }}">{{ $option }}{{ $attribute->unit ? ' ' . $attribute->unit : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <button type="button" onclick="document.getElementById('battery-finder-form').submit()" class="mt-4 w-full border-2 border-amber-500 text-amber-600 py-3 px-6 rounded-lg font-semibold hover:bg-amber-50 transition">
                    {{ __('common.apply_filters') }}
                </button>
            </div>
        </div>
        
        <!-- How it Works -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-10">{{ __('common.how_it_works') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('common.step1_title') }}</h3>
                    <p class="text-gray-600">{{ __('common.step1_desc') }}</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('common.step2_title') }}</h3>
                    <p class="text-gray-600">{{ __('common.step2_desc') }}</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-2h14a2 2 0 110 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('common.step3_title') }}</h3>
                    <p class="text-gray-600">{{ __('common.step3_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>