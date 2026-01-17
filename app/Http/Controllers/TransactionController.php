<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required'
        ]);

        $userId = Auth::id();
        // Ambil data keranjang
        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            foreach ($cartItems as $item) {
                // Pastikan harga diambil dengan benar (cek 'harga' atau 'price')
                $harga = $item->product->harga ?? $item->product->price;
                $totalHarga += $harga * $item->jumlah;
            }

            // 1. Simpan Transaksi Utama
            $transaction = Transaction::create([
                'user_id'           => $userId,
                'kode_transaksi'    => 'KOP-' . strtoupper(uniqid()),
                'total_harga'       => $totalHarga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status'            => 'menunggu',
                'tanggal'           => now()
            ]);

            // 2. Simpan Detail Transaksi
            foreach ($cartItems as $item) {
                $harga = $item->product->harga ?? $item->product->price;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item->produk_id, // PERBAIKAN: Pakai produk_id (sesuai tabel keranjang)
                    'quantity'       => $item->jumlah,    // PERBAIKAN: Pakai jumlah
                    'price'          => $harga
                ]);

                // Potong Stok
                $product = Product::find($item->produk_id);
                if($product) {
                    $product->decrement('stok', $item->jumlah);
                }
            }

            // 3. Hapus Keranjang
            Cart::where('user_id', $userId)->delete();

            DB::commit();
            return redirect()->route('customer.transactions')->with('success', 'Checkout berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal Checkout: ' . $e->getMessage());
        }
    }

    public function customerTransactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();
        return view('customer.transactions', compact('transactions'));
    }

    public function index()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('admin.transactions', compact('transactions'));
    }
}