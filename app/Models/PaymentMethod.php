<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'config',
        'supported_currencies',
        'supported_countries',
        'min_amount',
        'max_amount',
        'fee_percentage',
        'fee_fixed',
        'is_active',
        'is_sandbox',
        'sort_order',
        'icon',
    ];

    protected $casts = [
        'config' => 'array',
        'supported_currencies' => 'array',
        'supported_countries' => 'array',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'fee_percentage' => 'decimal:2',
        'fee_fixed' => 'decimal:2',
        'is_active' => 'boolean',
        'is_sandbox' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForCurrency($query, $currency)
    {
        return $query->whereJsonContains('supported_currencies', $currency);
    }

    public function scopeForCountry($query, $country)
    {
        return $query->whereJsonContains('supported_countries', $country);
    }

    public function scopeAvailableFor($query, $currency, $country, $amount = null)
    {
        return $query->active()
            ->forCurrency($currency)
            ->forCountry($country)
            ->when($amount, function ($q) use ($amount) {
                $q->where(function ($sub) use ($amount) {
                    $sub->whereNull('min_amount')->orWhere('min_amount', '<=', $amount);
                })->where(function ($sub) use ($amount) {
                    $sub->whereNull('max_amount')->orWhere('max_amount', '>=', $amount);
                });
            })
            ->orderBy('sort_order');
    }

    protected function feeAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->fee_fixed + ($this->fee_percentage / 100),
        );
    }

    public function calculateFee($amount)
    {
        return $this->fee_fixed + ($amount * $this->fee_percentage / 100);
    }

    public function getIconAttribute($value)
    {
        return $value ?? match ($this->type) {
            'stripe' => 'fab fa-stripe',
            'paypal' => 'fab fa-paypal',
            'bank_transfer' => 'fas fa-university',
            'cash_on_delivery' => 'fas fa-money-bill-wave',
            default => 'fas fa-credit-card',
        };
    }
}