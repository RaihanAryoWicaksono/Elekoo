<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{


    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name'        => 'required|string|max:255',
            'shipping_phone'       => 'required|string|max:20',
            'shipping_address'     => 'required|string',
            'shipping_city'        => 'required|string|max:100',
            'shipping_province'    => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
            'payment_method'       => 'required|in:transfer,cod',
            'notes'                => 'nullable|string',
        ]);

        $cart = auth()->user()->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $subtotal     = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = 15000;
        $total        = $subtotal + $shippingCost;

        $order = Order::create([
            'user_id'              => auth()->id(),
            'order_number'         => Order::generateOrderNumber(),
            'subtotal'             => $subtotal,
            'shipping_cost'        => $shippingCost,
            'total'                => $total,
            'status'               => 'pending',
            'payment_method'       => $request->payment_method,
            'payment_status'       => 'unpaid',
            'shipping_name'        => $request->shipping_name,
            'shipping_phone'       => $request->shipping_phone,
            'shipping_address'     => $request->shipping_address,
            'shipping_city'        => $request->shipping_city,
            'shipping_province'    => $request->shipping_province,
            'shipping_postal_code' => $request->shipping_postal_code,
            'notes'                => $request->notes,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name,
                'quantity'     => $item->quantity,
                'price'        => $item->product->price,
                'subtotal'     => $item->product->price * $item->quantity,
            ]);

            // Decrease stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear cart
        $cart->items()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat! Order #' . $order->order_number);
    }
}
