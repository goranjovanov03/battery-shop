<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class OverviewStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected int | string | array $columnSpan = 'full';

    public ?string $period = 'month';
    public ?string $startDate;
    public ?string $endDate;

    protected function getPeriodStart()
    {
        return match ($this->period) {
            'today' => now()->startOfDay(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'quarter' => now()->startOfQuarter(),
            'year' => now()->startOfYear(),
            default => now()->startOfMonth(),
        };
    }

    protected function getOrdersQuery()
    {
        $query = Order::query();

        if ($this->period === 'custom' && $this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                \Carbon\Carbon::parse($this->startDate)->startOfDay(),
                \Carbon\Carbon::parse($this->endDate)->endOfDay(),
            ]);
        } else {
            $query->where('created_at', '>=', $this->getPeriodStart());
        }

        return $query;
    }

    protected function getStats(): array
    {
        $totalRevenue = $this->getOrdersQuery()->where('payment_status', 'paid')->sum('grand_total');
        $totalOrders = $this->getOrdersQuery()->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $totalCustomers = $this->getOrdersQuery()->distinct('email')->count('email');

        $prevPeriodStart = $this->getPeriodStart()->copy()->subMonth();
        $prevRevenue = Order::whereBetween('created_at', [$prevPeriodStart, $this->getPeriodStart()])
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $revenueChange = $prevRevenue > 0 
            ? (($totalRevenue - $prevRevenue) / $prevRevenue) * 100 
            : 0;

        return [
            Stat::make(__('Total Revenue'), number_format($totalRevenue, 2) . ' MKD')
                ->description(__('vs last period') . ': ' . ($revenueChange >= 0 ? '+' : '') . number_format($revenueChange, 1) . '%')
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart($this->getRevenueChartData()),

            Stat::make(__('Total Orders'), $totalOrders)
                ->description(__('Average: ') . number_format($avgOrderValue, 2) . ' MKD')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make(__('Avg. Order Value'), number_format($avgOrderValue, 2) . ' MKD')
                ->description(__('per order'))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),

            Stat::make(__('Unique Customers'), $totalCustomers)
                ->description(__('new customers'))
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }

    protected function getRevenueChartData(): array
    {
        $data = $this->getOrdersQuery()
            ->where('payment_status', 'paid')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('revenue')
            ->map(fn ($v) => (float) $v)
            ->toArray();

        return $data ?: [0];
    }
}