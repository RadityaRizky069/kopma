<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Product $product)
    {
        return view('customer.checkout', compact('product'));
    }

    public function process(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required'
        ]);

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

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('customer.checkout-success');
    }
}
