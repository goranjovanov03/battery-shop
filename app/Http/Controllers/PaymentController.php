<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Process payment - redirect to gateway
     */
    public function process(Request $request, string $gateway)
    {
        $order = $this->getOrderFromSession();
        
        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Order not found');
        }

        $paymentMethod = PaymentMethod::where('slug', $gateway)
            ->active()
            ->first();

        if (!$paymentMethod) {
            return redirect()->route('checkout.index')->with('error', 'Payment method not available');
        }

        // Create transaction record
        $transaction = PaymentTransaction::create([
            'order_id' => $order->id,
            'payment_method_id' => $paymentMethod->id,
            'transaction_id' => Str::uuid()->toString(),
            'reference' => 'ORD-' . $order->id . '-' . Str::upper(Str::random(6)),
            'amount' => $order->total,
            'currency' => $order->currency ?? 'MKD',
            'status' => 'pending',
            'metadata' => [
                'order_number' => $order->id,
                'gateway' => $gateway,
            ],
        ]);

        // Store transaction ID in session for callback
        session(['payment_transaction_id' => $transaction->id]);

        // Process based on gateway type
        return match ($paymentMethod->type) {
            'stripe' => $this->processStripe($order, $paymentMethod, $transaction),
            'paypal' => $this->processPayPal($order, $paymentMethod, $transaction),
            'bank_transfer' => $this->processBankTransfer($order, $paymentMethod, $transaction),
            'cash_on_delivery' => $this->processCashOnDelivery($order, $paymentMethod, $transaction),
            default => redirect()->route('checkout.index')->with('error', 'Unsupported payment method'),
        };
    }

    /**
     * Handle payment callback from gateway
     */
    public function callback(Request $request, string $gateway)
    {
        $transactionId = session('payment_transaction_id');
        $transaction = PaymentTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('checkout.index')->with('error', 'Payment session expired');
        }

        $paymentMethod = $transaction->paymentMethod;

        $result = match ($paymentMethod->type) {
            'stripe' => $this->handleStripeCallback($request, $transaction),
            'paypal' => $this->handlePayPalCallback($request, $transaction),
            'bank_transfer' => $this->handleBankTransferCallback($request, $transaction),
            'cash_on_delivery' => $this->handleCashOnDeliveryCallback($request, $transaction),
            default => ['success' => false, 'message' => 'Unsupported payment method'],
        };

        if ($result['success']) {
            $this->completeOrder($transaction->order, $transaction);
            session()->forget('payment_transaction_id');
            session()->forget('cart');
            
            return redirect()->route('checkout.success', $transaction->order)
                ->with('success', 'Payment successful! Your order has been confirmed.');
        } else {
            return redirect()->route('checkout.index')
                ->with('error', $result['message'] ?? 'Payment failed. Please try again.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function cancel(Request $request, string $gateway)
    {
        $transactionId = session('payment_transaction_id');
        $transaction = PaymentTransaction::find($transactionId);

        if ($transaction) {
            $transaction->markFailed('Payment cancelled by user');
        }

        session()->forget('payment_transaction_id');

        return redirect()->route('checkout.index')
            ->with('error', 'Payment was cancelled. You can try again or choose a different payment method.');
    }

    /**
     * Handle webhook notifications
     */
    public function webhook(Request $request, string $gateway)
    {
        $paymentMethod = PaymentMethod::where('slug', $gateway)->first();

        if (!$paymentMethod) {
            return response()->json(['error' => 'Gateway not found'], 404);
        }

        try {
            $result = match ($paymentMethod->type) {
                'stripe' => $this->handleStripeWebhook($request, $paymentMethod),
                'paypal' => $this->handlePayPalWebhook($request, $paymentMethod),
                'bank_transfer' => $this->handleBankTransferWebhook($request, $paymentMethod),
                default => ['success' => false, 'message' => 'Unsupported gateway'],
            };

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Payment webhook error: ' . $e->getMessage(), [
                'gateway' => $gateway,
                'payload' => $request->all(),
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    // ==================== STRIPE ====================

    protected function processStripe($order, $paymentMethod, $transaction)
    {
        // In production, create Stripe Checkout Session
        // For now, simulate with a redirect to success
        if (config('app.debug') || $paymentMethod->is_sandbox) {
            return redirect()->route('payment.callback', ['gateway' => 'stripe'])
                ->with('stripe_simulated', true);
        }

        // Real Stripe integration would go here:
        // $stripe = new \Stripe\StripeClient($paymentMethod->config['secret_key']);
        // $session = $stripe->checkout->sessions->create([...]);
        // return redirect($session->url);

        return redirect()->route('payment.callback', ['gateway' => 'stripe']);
    }

    protected function handleStripeCallback(Request $request, PaymentTransaction $transaction)
    {
        if ($request->has('stripe_simulated')) {
            $transaction->markCompleted(['simulated' => true]);
            return ['success' => true];
        }

        // Real implementation would verify Stripe session
        // $stripe = new \Stripe\StripeClient($paymentMethod->config['secret_key']);
        // $session = $stripe->checkout->sessions->retrieve($request->session_id);
        // if ($session->payment_status === 'paid') { ... }

        $transaction->markCompleted(['simulated' => true]);
        return ['success' => true];
    }

    protected function handleStripeWebhook(Request $request, PaymentMethod $paymentMethod)
    {
        // Verify webhook signature
        // $endpoint_secret = $paymentMethod->config['webhook_secret'];
        // $event = \Stripe\Webhook::constructEvent($request->getContent(), $request->header('Stripe-Signature'), $endpoint_secret);
        
        // Handle event types
        // if ($event->type === 'checkout.session.completed') { ... }

        return ['success' => true, 'message' => 'Webhook received'];
    }

    // ==================== PAYPAL ====================

    protected function processPayPal($order, $paymentMethod, $transaction)
    {
        if (config('app.debug') || $paymentMethod->is_sandbox) {
            return redirect()->route('payment.callback', ['gateway' => 'paypal'])
                ->with('paypal_simulated', true);
        }

        // Real PayPal integration would create order and redirect to approval URL
        return redirect()->route('payment.callback', ['gateway' => 'paypal']);
    }

    protected function handlePayPalCallback(Request $request, PaymentTransaction $transaction)
    {
        if ($request->has('paypal_simulated')) {
            $transaction->markCompleted(['simulated' => true]);
            return ['success' => true];
        }

        // Real implementation would capture PayPal order
        $transaction->markCompleted(['simulated' => true]);
        return ['success' => true];
    }

    protected function handlePayPalWebhook(Request $request, PaymentMethod $paymentMethod)
    {
        // Verify webhook signature and process
        return ['success' => true, 'message' => 'PayPal webhook received'];
    }

    // ==================== BANK TRANSFER (Macedonian Banks) ====================

    protected function processBankTransfer($order, $paymentMethod, $transaction)
    {
        // For Macedonian banks (NLB, Stopanska, MNT), redirect to their payment page
        if (config('app.debug') || $paymentMethod->is_sandbox) {
            return redirect()->route('payment.callback', ['gateway' => $paymentMethod->slug])
                ->with('bank_simulated', true);
        }

        // Real implementation would generate payment form for the bank
        // Example: generate form with merchant_id, amount, order_id, signature
        // return view('payment.bank-form', compact('paymentMethod', 'transaction'));

        return redirect()->route('payment.callback', ['gateway' => $paymentMethod->slug]);
    }

    protected function handleBankTransferCallback(Request $request, PaymentTransaction $transaction)
    {
        if ($request->has('bank_simulated')) {
            $transaction->markCompleted(['simulated' => true]);
            return ['success' => true];
        }

        // Real implementation would verify bank response
        // Check signature, status code, etc.
        $transaction->markCompleted(['simulated' => true]);
        return ['success' => true];
    }

    protected function handleBankTransferWebhook(Request $request, PaymentMethod $paymentMethod)
    {
        // Handle bank webhook notification
        return ['success' => true, 'message' => 'Bank webhook received'];
    }

    // ==================== CASH ON DELIVERY ====================

    protected function processCashOnDelivery($order, $paymentMethod, $transaction)
    {
        // Cash on delivery - order is confirmed immediately
        $transaction->markCompleted(['method' => 'cash_on_delivery']);
        
        $this->completeOrder($order, $transaction);
        session()->forget('payment_transaction_id');
        session()->forget('cart');

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Order confirmed! You will pay when the order is delivered.');
    }

    protected function handleCashOnDeliveryCallback(Request $request, PaymentTransaction $transaction)
    {
        $transaction->markCompleted(['method' => 'cash_on_delivery']);
        return ['success' => true];
    }

    // ==================== HELPERS ====================

    protected function getOrderFromSession(): ?Order
    {
        // Get the latest pending order for the current user/guest
        if (auth()->check()) {
            return Order::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->whereNull('payment_method_id')
                ->latest()
                ->first();
        }

        // For guest, check session or last order
        return Order::whereNull('user_id')
            ->where('status', 'pending')
            ->whereNull('payment_method_id')
            ->latest()
            ->first();
    }

    protected function completeOrder(Order $order, PaymentTransaction $transaction)
    {
        $order->update([
            'payment_method_id' => $transaction->payment_method_id,
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        // Clear cart
        session()->forget('cart');
    }
}