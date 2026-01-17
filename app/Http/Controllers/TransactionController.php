<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /* ================= ADMIN ================= */

    // Admin: daftar semua transaksi
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('admin.transactions', compact('transactions'));
    }

    // Admin: ubah status transaksi
    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();

        return redirect()->back()
            ->with('success', 'Status transaksi diperbarui');
    }

    /* ================= CUSTOMER (CHECKOUT DARI CART) ================= */

    public function checkout(Request $request)
    {
        // VALIDASI METODE PEMBAYARAN
        $request->validate([
            'payment_method' => 'required'
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Keranjang kosong');
        }

        // HITUNG TOTAL
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->harga;
        }

        // SIMPAN TRANSAKSI
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method
        ]);

        // SIMPAN ITEM TRANSAKSI
        foreach ($cartItems as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->harga
            ]);

            // KURANGI STOK PRODUK
            $item->product->decrement('stok', $item->quantity);
        }

        // KOSONGKAN CART
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('customer.transactions')
            ->with('success', 'Checkout berhasil, pesanan sedang diproses');
    }

    /* ================= CUSTOMER ================= */

    // Riwayat transaksi customer
    public function customerTransactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.transactions', compact('transactions'));
    }
}
