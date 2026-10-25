<x-filament-panels::page>
    <x-slot name="heading">
        {{ __('Sales Reports') }}
    </x-slot>

    <x-slot name="subheading">
        {{ __('Overview of sales performance') }}
    </x-slot>

    <!-- Period Filter Form -->
    <form wire:submit="updatePeriod" class="mb-6">
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700">{{ __('Period:') }}</label>
                <select wire:model="period" class="w-40 px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <option value="today">{{ __('Today') }}</option>
                    <option value="week">{{ __('This Week') }}</option>
                    <option value="month" selected>{{ __('This Month') }}</option>
                    <option value="quarter">{{ __('This Quarter') }}</option>
                    <option value="year">{{ __('This Year') }}</option>
                    <option value="custom">{{ __('Custom Range') }}</option>
                </select>
            </div>

            @if($period === 'custom')
                <div class="flex items-center gap-2">
                    <input type="date" wire:model="startDate" class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900" max="{{ now()->format('Y-m-d') }}">
                    <span class="text-gray-400">-</span>
                    <input type="date" wire:model="endDate" class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900" max="{{ now()->format('Y-m-d') }}">
                </div>
            @endif

            <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                {{ __('Apply') }}
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2 fi-widget">
            <div class="fi-widget-header">
                <h3 class="fi-widget-heading">{{ __('Revenue Trend') }}</h3>
            </div>
            <div class="fi-widget-content">
                <div class="h-80" wire:ignore>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="fi-widget">
            <div class="fi-widget-header">
                <h3 class="fi-widget-heading">{{ __('Top Products') }}</h3>
            </div>
            <div class="fi-widget-content">
                <div class="space-y-3">
                    @forelse($getTopProducts as $index => $product)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="text-lg font-bold text-amber-600">{{ $index + 1 }}</span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $product['name'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $product['total_sold'] }} {{ __("sold") }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">{{ number_format($product['total_revenue'], 2) }} MKD</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">{{ __('No products sold in this period') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="fi-widget">
            <div class="fi-widget-header">
                <h3 class="fi-widget-heading">{{ __('Payment Methods') }}</h3>
            </div>
            <div class="fi-widget-content">
                <div class="space-y-3">
                    @forelse($getPaymentMethodStats as $method)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="{{ $method['slug'] === 'stripe' ? 'fab fa-stripe text-purple-500' : ($method['slug'] === 'paypal' ? 'fab fa-paypal text-blue-500' : 'fas fa-university text-green-500') }} text-xl"></i>
                                <span class="font-medium text-gray-900">{{ $method['name'] }}</span>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">{{ number_format($method['total_amount'], 2) }} MKD</p>
                                <p class="text-sm text-gray-500">{{ $method['transactions'] }} {{ __("transactions") }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">{{ __('No payment data in this period') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('livewire:navigated', () => {
                const ctx = document.getElementById('revenueChart');
                if (!ctx) return;

                const revenueData = @json($getRevenueByDay);

                if (window.revenueChart) {
                    window.revenueChart.destroy();
                }

                window.revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: revenueData.map(d => d.date),
                        datasets: [
                            {
                                label: '{{ __("Revenue (MKD)") }}',
                                data: revenueData.map(d => d.revenue),
                                borderColor: '#f59e0b',
                                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                fill: true,
                                tension: 0.3,
                            },
                            {
                                label: '{{ __("Orders") }}',
                                data: revenueData.map(d => d.orders),
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                fill: false,
                                tension: 0.3,
                                yAxisID: 'y1',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: '{{ __("Revenue (MKD)") }}'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: '{{ __("Orders") }}'
                                },
                                grid: {
                                    drawOnChartArea: false,
                                },
                            },
                        },
                    }
                });
            });
        </script>
    @endpush
</x-filament-panels::page>