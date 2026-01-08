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
        return redirect()->back()->with('success','Status transaksi diperbarui');
    }

    // Customer: checkout
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if($cartItems->isEmpty()){
            return redirect()->back()->with('error','Keranjang kosong');
        }

        $total = 0;
        foreach($cartItems as $item){
            $total += $item->quantity * $item->product->price;
        }

        $transaction = Transaction::create([
            'user_id'=>Auth::id(),
            'total'=>$total,
            'status'=>'menunggu'
        ]);

        foreach($cartItems as $item){
            TransactionItem::create([
                'transaction_id'=>$transaction->id,
                'product_id'=>$item->product_id,
                'quantity'=>$item->quantity,
                'price'=>$item->product->price
            ]);

            // kurangi stok produk
            $item->product->decrement('stock', $item->quantity);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('customer.transactions')->with('success','Checkout berhasil');
    }

    // Customer: riwayat transaksi
    public function customerTransactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();
        return view('customer.transactions', compact('transactions'));
    }
}
