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

        // Cek apakah stok masih ada
        if ($product->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk habis!');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('produk_id', $product->id)
                    ->first();

        if ($cart) {
            // Jika sudah ada di keranjang, cek stok sebelum tambah
            if ($cart->jumlah + 1 > $product->stok) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia!');
            }
            $cart->increment('jumlah');
        } else {
            // Jika belum ada, buat baru
            Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $product->id,
                'jumlah' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil masuk keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $product = $cartItem->product;
        $type = $request->type; // 'plus' atau 'minus'

        if ($type == 'plus') {
            if ($cartItem->jumlah + 1 > $product->stok) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $cartItem->increment('jumlah');
        } else {
            if ($cartItem->jumlah > 1) {
                $cartItem->decrement('jumlah');
            } else {
                $cartItem->delete();
                return back()->with('success', 'Produk dihapus dari keranjang');
            }
        }

        return back()->with('success', 'Keranjang diperbarui');
    }
}