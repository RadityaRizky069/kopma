<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('customer.cart', compact('cartItems'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::firstOrCreate([
            'user_id'=>Auth::id(),
            'product_id'=>$product->id
        ]);

        $cart->increment('quantity');

        return redirect()->back()->with('success','Produk ditambahkan ke keranjang');
    }
}
