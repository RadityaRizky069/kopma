<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('customer.cart', compact('cartItems'));
    }

    // FUNGSI INI YANG KURANG (Untuk tambah ke keranjang)
    public function add(Request $request, $id)
{
    $product = \App\Models\Product::findOrFail($id);
    
    if ($product->stok <= 0) {
        return back()->with('error', 'Maaf, stok barang habis.');
    }

    $cartItem = \App\Models\Cart::where('user_id', auth()->id())
                    ->where('produk_id', $id)
                    ->first();

    if ($cartItem) {
        $baru = $cartItem->jumlah + 1;
        if ($baru > $product->stok) {
            return back()->with('error', 'Gagal: Jumlah di keranjang sudah mencapai batas stok.');
        }
        $cartItem->update(['jumlah' => $baru]);
    } else {
        \App\Models\Cart::create([
            'user_id' => auth()->id(),
            'produk_id' => $id,
            'jumlah' => 1
        ]);
    }

    // KUNCI DI SINI: Menggunakan back() agar halaman tidak pindah
    return back()->with('success', $product->nama_produk . ' berhasil ditambah ke keranjang!');
}
    // Untuk update jumlah (Tambah/Kurang) di halaman keranjang
    public function update(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $product = $cartItem->product;

        if ($request->jumlah > $product->stok) {
            return back()->with('error', 'Stok tidak mencukupi (Sisa: ' . $product->stok . ')');
        }

        if ($request->jumlah < 1) {
            $cartItem->delete();
            return back()->with('success', 'Produk dihapus dari keranjang.');
        }

        $cartItem->update(['jumlah' => $request->jumlah]);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    // Untuk hapus item
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();
        return back()->with('success', 'Item berhasil dihapus.');
    }
}