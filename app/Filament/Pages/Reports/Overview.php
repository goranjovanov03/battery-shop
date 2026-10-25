<?php

namespace App\Filament\Pages\Reports;

use App\Filament\Widgets\OverviewStatsWidget;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\Product;
use Filament\Pages\Page;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class Overview extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Reports';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.reports.overview';
    protected static ?string $title = 'Reports';

    public ?string $period = 'month';
    public ?string $startDate;
    public ?string $endDate;

    protected function getHeaderWidgets(): array
    {
        return [
            OverviewStatsWidget::class,
        ];
    }

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function getOrdersQuery()
    {
        $query = Order::query();

        if ($this->period === 'custom' && $this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ]);
        } else {
            $query->where('created_at', '>=', $this->getPeriodStart());
        }

        return $query;
    }

    protected function getPeriodStart(): Carbon
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

    public function getTotalRevenue(): float
    {
        return $this->getOrdersQuery()->where('payment_status', 'paid')->sum('grand_total');
    }

    public function getTotalOrders(): int
    {
        return $this->getOrdersQuery()->count();
    }

    public function getAverageOrderValue(): float
    {
        $orders = $this->getTotalOrders();
        return $orders > 0 ? $this->getTotalRevenue() / $orders : 0;
    }

    public function getTotalCustomers(): int
    {
        return $this->getOrdersQuery()->distinct('email')->count('email');
    }

    #[Computed]
    public function getRevenueByDay(): array
    {
        return $this->getOrdersQuery()
            ->where('payment_status', 'paid')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn ($item) => [
                'date' => $item->date,
                'revenue' => (float) $item->revenue,
                'orders' => (int) $item->orders,
            ])
            ->toArray();
    }

    #[Computed]
    public function getTopProducts(): array
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', $this->getPeriodStart())
            ->where('orders.payment_status', 'paid')
            ->select(
                'products.name',
                'products.slug',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.slug')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get()
            ->map(fn ($item) => [
                'name' => $item->name,
                'slug' => $item->slug,
                'total_sold' => (int) $item->total_sold,
                'total_revenue' => (float) $item->total_revenue,
            ])
            ->toArray();
    }

    #[Computed]
    public function getPaymentMethodStats(): array
    {
        return DB::table('payment_transactions')
            ->join('orders', 'payment_transactions.order_id', '=', 'orders.id')
            ->join('payment_methods', 'payment_transactions.payment_method_id', '=', 'payment_methods.id')
            ->where('payment_transactions.created_at', '>=', $this->getPeriodStart())
            ->where('payment_transactions.status', 'completed')
            ->select(
                'payment_methods.name',
                'payment_methods.slug',
                DB::raw('COUNT(*) as transactions'),
                DB::raw('SUM(payment_transactions.amount) as total_amount')
            )
            ->groupBy('payment_methods.id', 'payment_methods.name', 'payment_methods.slug')
            ->orderByDesc('total_amount')
            ->get()
            ->map(fn ($item) => [
                'name' => $item->name,
                'slug' => $item->slug,
                'transactions' => (int) $item->transactions,
                'total_amount' => (float) $item->total_amount,
            ])
            ->toArray();
    }

    public function getViewData(): array
    {
        return [
            'getTopProducts' => $this->getTopProducts(),
            'getPaymentMethodStats' => $this->getPaymentMethodStats(),
            'getRevenueByDay' => $this->getRevenueByDay(),
        ];
    }
}