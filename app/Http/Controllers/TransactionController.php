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
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        DB::beginTransaction();
        try {
            $totalHarga = 0;

            // Validasi stok sebelum proses
            foreach ($cartItems as $item) {
                if ($item->product->stok < $item->jumlah) {
                    throw new \Exception("Stok produk '{$item->product->nama_produk}' tidak mencukupi.");
                }
                $harga = $item->product->harga ?? $item->product->price;
                $totalHarga += $harga * $item->jumlah;
            }

            // ================== HITUNG POIN (POTONGAN HARGA) ==================
            $user = Auth::user();
            $usePoints = 0;
            $potongan  = 0;

            if ($user->is_member && $request->filled('use_points')) {
                $usePoints = (int) $request->use_points;

                if ($usePoints > $user->points) {
                    $usePoints = $user->points;
                }

                $potongan = $usePoints * 100; // 1 poin = Rp 100

                if ($potongan > $totalHarga) {
                    $potongan  = $totalHarga;
                    $usePoints = floor($totalHarga / 100);
                }

                $totalHarga -= $potongan;
            }

            // ================= SIMPAN TRANSAKSI =================
            // Status awal: 'menunggu'
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

            // ================= DETAIL & POTONG STOK =================
            foreach ($cartItems as $item) {
                $harga = $item->product->harga ?? $item->product->price;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item->produk_id,
                    'quantity'       => $item->jumlah,
                    'price'          => $harga
                ]);

                // Kurangi stok produk
                Product::where('id', $item->produk_id)->decrement('stok', $item->jumlah);
            }

            // Hapus keranjang
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
            $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);
            $user = $transaction->user;

            // Jika status lama sudah 'selesai' atau 'ditolak', cegah perubahan lagi agar data tidak double/ngaco
            if (in_array($transaction->status, ['selesai', 'ditolak'])) {
                return redirect()->back()->with('error', 'Transaksi yang sudah selesai atau ditolak tidak dapat diubah lagi.');
            }

            // ================= STATUS SELESAI =================
            if ($request->status === 'selesai') {
                if ($user && $user->is_member) {
                    // 1. Potong poin yang dipakai saat checkout (Poin baru benar-benar hilang saat transaksi selesai)
                    if ($transaction->used_points > 0) {
                        $user->decrement('points', $transaction->used_points);
                    }

                    // 2. Tambah poin baru dari transaksi ini (Rp 10.000 = 1 poin)
                    $earnedPoints = floor($transaction->total_harga / 10000);
                    if ($earnedPoints > 0) {
                        $user->increment('points', $earnedPoints);
                    }
                }
            }

            // ================= STATUS DITOLAK (PENTING: BALIKIN STOK) =================
            if ($request->status === 'ditolak') {
                foreach ($transaction->items as $item) {
                    // Tambahkan kembali stok yang tadi dikurangi saat checkout
                    Product::where('id', $item->product_id)->increment('stok', $item->quantity);
                }
            }

            // UPDATE STATUS KE DATABASE
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