<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $product = Product::with('images')->find($id);
            if ($product) {
                $item['product'] = $product;
                $item['total'] = $product->effective_price * $item['quantity'];
                $cartItems[$id] = $item;
                $subtotal += $item['total'];
            }
        }

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (! $product->is_active) {
            return response()->json(['message' => 'Product is not available'], 400);
        }

        if ($product->stock_quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            if ($product->stock_quantity < $newQuantity) {
                return response()->json(['message' => 'Insufficient stock'], 400);
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart',
            'cart_count' => $this->getCartCount($cart),
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (! isset($cart[$id])) {
            return response()->json(['message' => 'Product not in cart'], 404);
        }

        if ($product->stock_quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        $subtotal = $this->calculateSubtotal($cart);

        return response()->json([
            'message' => 'Cart updated',
            'cart_count' => $this->getCartCount($cart),
            'subtotal' => $subtotal,
            'item_total' => $product->effective_price * $request->quantity,
        ]);
    }

    public function remove($id): JsonResponse
    {
        $cart = session()->get('cart', []);

        if (! isset($cart[$id])) {
            return response()->json(['message' => 'Product not in cart'], 404);
        }

        unset($cart[$id]);
        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product removed from cart',
            'cart_count' => $this->getCartCount($cart),
            'subtotal' => $this->calculateSubtotal($cart),
        ]);
    }

    public function clear(): JsonResponse
    {
        session()->forget('cart');

        return response()->json([
            'message' => 'Cart cleared',
            'cart_count' => 0,
            'subtotal' => 0,
        ]);
    }

    public function count(): JsonResponse
    {
        $cart = session()->get('cart', []);

        return response()->json([
            'count' => $this->getCartCount($cart),
        ]);
    }

    private function getCartCount(array $cart): int
    {
        return array_sum(array_column($cart, 'quantity'));
    }

    private function calculateSubtotal(array $cart): float
    {
        $subtotal = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $subtotal += $product->effective_price * $item['quantity'];
            }
        }

        return $subtotal;
    }
}
