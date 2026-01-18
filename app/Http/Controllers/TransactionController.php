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
    // ================= CHECKOUT =================
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required'
        ]);

        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        DB::beginTransaction();
        try {
            $totalHarga = 0;

            foreach ($cartItems as $item) {
                $harga = $item->product->harga ?? $item->product->price;
                $totalHarga += $harga * $item->jumlah;
            }

            // ================== HITUNG POIN (BELUM DIPOTONG) ==================
            $user = Auth::user();
            $usePoints = 0;
            $potongan  = 0;

            if ($user->is_member && $request->filled('use_points')) {
                $usePoints = (int) $request->use_points;

                // Tidak boleh melebihi poin user
                if ($usePoints > $user->points) {
                    $usePoints = $user->points;
                }

                // 1 poin = Rp 100
                $potongan = $usePoints * 100;

                // Potongan tidak boleh lebih dari total harga
                if ($potongan > $totalHarga) {
                    $potongan  = $totalHarga;
                    $usePoints = floor($totalHarga / 100);
                }

                $totalHarga -= $potongan;
            }

            // ================= SIMPAN TRANSAKSI =================
            $transaction = Transaction::create([
                'user_id'           => $userId,
                'kode_transaksi'    => 'KOP-' . strtoupper(uniqid()),
                'total_harga'       => $totalHarga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status'            => 'menunggu',
                'tanggal'           => now(),
                'used_points'       => $usePoints,
                'discount'          => $potongan,
            ]);

            // ================= DETAIL TRANSAKSI =================
            foreach ($cartItems as $item) {
                $harga = $item->product->harga ?? $item->product->price;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item->produk_id,
                    'quantity'       => $item->jumlah,
                    'price'          => $harga
                ]);

                Product::where('id', $item->produk_id)
                    ->decrement('stok', $item->jumlah);
            }

            Cart::where('user_id', $userId)->delete();

            DB::commit();
            return redirect()->route('customer.transactions')
                ->with('success', 'Checkout berhasil! Menunggu konfirmasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal Checkout: ' . $e->getMessage());
        }
    }

    // ================= TRANSAKSI CUSTOMER =================
    public function customerTransactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.transactions', compact('transactions'));
    }

    // ================= TRANSAKSI ADMIN =================
    public function index()
    {
        $transactions = Transaction::with('user')
            ->latest()
            ->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    // ================= UPDATE STATUS (ADMIN) =================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,selesai,ditolak'
        ]);

        DB::beginTransaction();
        try {
            $transaction = Transaction::with('user')->findOrFail($id);
            $user = $transaction->user;

            // ================= STATUS SELESAI =================
            if ($request->status === 'selesai') {

                if ($user && $user->is_member) {

                    // POTONG POIN YANG DIPAKAI
                    if ($transaction->used_points > 0) {
                        $user->decrement('points', $transaction->used_points);
                    }

                    // TAMBAH POIN BARU
                    // (Rp 10.000 = 1 poin)
                    $earnedPoints = floor($transaction->total_harga / 10000);
                    if ($earnedPoints > 0) {
                        $user->increment('points', $earnedPoints);
                    }
                }
            }

            // ================= STATUS DITOLAK =================
            // Tidak perlu balikin poin
            // karena poin belum pernah dipotong

            // UPDATE STATUS
            $transaction->update([
                'status' => $request->status
            ]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Status transaksi berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }
}
