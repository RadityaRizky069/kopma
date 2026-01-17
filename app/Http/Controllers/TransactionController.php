<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /* ================= ADMIN ================= */

    // Admin: daftar semua transaksi
    public function index()
    {
        $transactions = Transaction::all();
        return view('admin.transactions', compact('transactions'));
    }

    // Admin: ubah status transaksi
    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->input('status');
        $transaction->save();

        return redirect()->back()
            ->with('success','Status transaksi diperbarui');
    }

    /* ================= CUSTOMER (CHECKOUT DARI CART) ================= */

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()
                ->with('error','Keranjang kosong');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->harga;
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
            'payment_method' => 'cart'
        ]);

        foreach ($cartItems as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->harga
            ]);

            // Kurangi stok
            $item->product->decrement('stok', $item->quantity);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('customer.transactions')
            ->with('success','Checkout keranjang berhasil');
    }

    /* ================= CUSTOMER (CHECKOUT LANGSUNG DARI PRODUK) ================= */

    // FORM CHECKOUT (pilih metode pembayaran)
    public function checkoutForm(Product $product)
    {
        return view('customer.checkout', compact('product'));
    }

    // PROSES CHECKOUT PRODUK
    public function checkoutProduct(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required'
        ]);

        // Cek stok
        if ($request->quantity > $product->stok) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $total = $product->harga * $request->quantity;

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method
        ]);

        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->harga
        ]);

        // Kurangi stok
        $product->decrement('stok', $request->quantity);

        return redirect()->route('customer.transactions')
            ->with('success','Checkout produk berhasil');
    }

    /* ================= CUSTOMER ================= */

    // Riwayat transaksi customer
    public function customerTransactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();
        return view('customer.transactions', compact('transactions'));
    }
}
