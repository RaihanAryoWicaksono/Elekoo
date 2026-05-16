<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product.category')->first();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'integer|min:1|max:' . $product->stock]);

        $quantity = $request->get('quantity', 1);

        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $cart = auth()->user()->cart()->firstOrCreate(['user_id' => auth()->id()]);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Stok tidak cukup!');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ]);
        }

        return back()->with('success', "{$product->name} ditambahkan ke keranjang!");
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        if ($request->quantity > $cartItem->product->stock) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }
        $cartItem->delete();
        return back()->with('success', 'Produk dihapus dari keranjang!');
    }
}
