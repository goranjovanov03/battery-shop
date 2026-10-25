<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method_id',
        'transaction_id',
        'reference',
        'amount',
        'currency',
        'status',
        'gateway_response',
        'metadata',
        'error_message',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function markCompleted($gatewayResponse = null)
    {
        $this->update([
            'status' => 'completed',
            'processed_at' => now(),
            'gateway_response' => $gatewayResponse,
        ]);
    }

    public function markFailed($errorMessage, $gatewayResponse = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'gateway_response' => $gatewayResponse,
        ]);
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'completed';
    }
}