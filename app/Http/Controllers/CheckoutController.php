<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $product = Product::with('images')->find($id);
            if ($product && $product->is_active) {
                if ($product->stock_quantity < $item['quantity']) {
                    return redirect()->route('cart.index')->with('error', "Insufficient stock for {$product->name}");
                }
                $item['product'] = $product;
                $item['total'] = $product->effective_price * $item['quantity'];
                $cartItems[$id] = $item;
                $subtotal += $item['total'];
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'No valid items in cart');
        }

        $shipping = $subtotal >= 100 ? 0 : 15.00;
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $shipping + $tax;

        // Get available payment methods for this order
        $paymentMethods = PaymentMethod::active()
            ->forCurrency('MKD')
            ->forCountry('MK')
            ->orderBy('sort_order')
            ->get();

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|string|exists:payment_methods,slug',
        ]);

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product && $product->is_active) {
                if ($product->stock_quantity < $item['quantity']) {
                    return back()->with('error', "Insufficient stock for {$product->name}");
                }
                $item['product'] = $product;
                $item['total'] = $product->effective_price * $item['quantity'];
                $cartItems[$id] = $item;
                $subtotal += $item['total'];
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'No valid items in cart');
        }

        $shipping = $subtotal >= 100 ? 0 : 15.00;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        // Get payment method to calculate fees
        $paymentMethod = PaymentMethod::where('slug', $request->payment_method)
            ->active()
            ->first();

        $paymentFee = $paymentMethod ? $paymentMethod->calculateFee($total) : 0;
        $grandTotal = $total + $paymentFee;

        try {
            $order = DB::transaction(function () use ($cartItems, $subtotal, $shipping, $tax, $total, $grandTotal, $paymentFee, $paymentMethod, $request) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                    'notes' => $request->notes,
                    'subtotal' => $subtotal,
                    'shipping' => $shipping,
                    'tax' => $tax,
                    'total' => $total,
                    'payment_fee' => $paymentFee,
                    'grand_total' => $grandTotal,
                    'payment_method_id' => $paymentMethod?->id,
                    'payment_status' => 'pending',
                    'status' => 'pending',
                    'currency' => 'MKD',
                ]);

                foreach ($cartItems as $item) {
                    $product = $item['product'];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->effective_price,
                        'total' => $item['total'],
                    ]);

                    // Decrease stock
                    $product->decrement('stock_quantity', $item['quantity']);
                }

                return $order;
            });

            // Store order data in session for payment processing
            session([
                'checkout_order_id' => $order->id,
                'checkout_payment_method' => $request->payment_method,
            ]);

            // Redirect to payment processing
            return redirect()->route('payment.process', ['gateway' => $request->payment_method]);

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    public function success(Order $order)
    {
        // Verify the order belongs to the current user (or guest)
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}