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
        // Pastikan relasi 'product' ada di Model Cart
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('customer.cart', compact('cartItems'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        // PERBAIKAN DI SINI: Sesuaikan dengan kolom database kamu
        $cart = Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'produk_id' => $product->id  // Database kamu pakai 'produk_id'
            ],
            [
                'jumlah' => 0 // Inisialisasi jumlah awal jika baru dibuat
            ]
        );

        // Tambah jumlahnya (database kamu pakai kolom 'jumlah')
        $cart->increment('jumlah');

        return redirect()->back()->with('success', 'Produk berhasil masuk keranjang!');
    }
}