<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{


    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product.category')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        $wishlist = auth()->user()->wishlists()->where('product_id', $product->id)->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Produk dihapus dari wishlist!';
        } else {
            auth()->user()->wishlists()->create(['product_id' => $product->id]);
            $message = 'Produk ditambahkan ke wishlist!';
        }

        return back()->with('success', $message);
    }
}
