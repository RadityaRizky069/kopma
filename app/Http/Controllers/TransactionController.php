<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\InstallmentPayment; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // ================= CHECKOUT =================
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required'
        ]);

        $userId = Auth::id();
        $user = Auth::user();

        // ================== LOGIKA BLOCKER CICILAN ==================
        $tunggakan = Transaction::where('user_id', $userId)
            ->where('is_installment', 1)
            ->where('status', '!=', 'selesai')
            ->where('installment_due', '<', now())
            ->whereRaw('installment_paid < installment_total')
            ->first();

        if ($tunggakan) {
            return redirect()->route('customer.transactions')->with('error', 
                'Checkout diblokir! Kamu memiliki tunggakan cicilan pada transaksi ' . $tunggakan->kode_transaksi . '. Mohon lunasi terlebih dahulu.');
        }

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

            // ================== LOGIKA POIN ==================
            $usePoints = 0;
            $potongan  = 0;

            if ($user->is_member && $request->filled('use_points')) {
                $usePoints = (int) $request->use_points;
                if ($usePoints > $user->points) $usePoints = $user->points;

                $potongan = $usePoints * 100; // 1 poin = Rp 100
                if ($potongan > $totalHarga) {
                    $potongan  = $totalHarga;
                    $usePoints = floor($totalHarga / 100);
                }
                $totalHarga -= $potongan;
            }

            // ================== LOGIKA HITUNG CICILAN ==================
            $isInstallment = 0;
            $duration = null;
            $dueDate = null;
            $installmentAmount = 0;

            if ($request->metode_pembayaran === 'Cicilan') {
                if (!$user->is_member) {
                    throw new \Exception('Maaf, fitur cicilan hanya tersedia untuk member aktif.');
                }
                if (!$request->filled('installment_duration')) {
                    throw new \Exception('Mohon pilih durasi cicilan.');
                }

                $isInstallment = 1;
                $duration = (int) $request->installment_duration;
                $dueDate = now()->addDays($duration);

                $jumlahTermin = ($duration <= 14) ? ($duration / 7) : ($duration / 30);
                $installmentAmount = ceil($totalHarga / $jumlahTermin);
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
                'is_installment'        => $isInstallment,
                'installment_duration'  => $duration,
                'installment_total'     => $totalHarga,
                'installment_amount'    => $installmentAmount,
                'installment_paid'      => 0,
                'installment_due'       => $dueDate,
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

                Product::where('id', $item->produk_id)->decrement('stok', $item->jumlah);
            }

            Cart::where('user_id', $userId)->delete();

            DB::commit();
            return redirect()->route('customer.transactions')
                ->with('success', 'Checkout berhasil! ' . ($isInstallment ? 'Tagihan cicilan telah dibuat.' : 'Menunggu konfirmasi admin.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal Checkout: ' . $e->getMessage());
        }
    }

    // ================= PAY INSTALLMENT (TAMPILAN) =================
    public function payInstallment($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $sisaBayar = $transaction->installment_total - $transaction->installment_paid;

        return view('customer.pay_installment', compact('transaction', 'sisaBayar'));
    }

    // ================= PROCESS INSTALLMENT =================
    public function processInstallment(Request $request, $id)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1000'
        ]);

        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $user = Auth::user();
        $sisaBayar = $transaction->installment_total - $transaction->installment_paid;

        if ($request->jumlah_bayar > $sisaBayar) {
            return redirect()->back()->with('error', 'Jumlah bayar melebihi sisa tagihan!');
        }

        DB::beginTransaction();
        try {
            InstallmentPayment::create([
                'transaction_id' => $transaction->id,
                'amount'         => $request->jumlah_bayar,
                'payment_date'   => now(),
            ]);

            $transaction->increment('installment_paid', $request->jumlah_bayar);

            $checkStatus = Transaction::find($id);
            if ($checkStatus->installment_paid >= $checkStatus->installment_total) {
                $checkStatus->update(['status' => 'selesai']);

                if ($user->is_member) {
                    if ($checkStatus->used_points > 0) {
                        $user->decrement('points', $checkStatus->used_points);
                    }
                    $earnedPoints = floor($checkStatus->total_harga / 10000);
                    if ($earnedPoints > 0) {
                        $user->increment('points', $earnedPoints);
                    }
                }
            }

            DB::commit();
            return redirect()->route('customer.transactions')
                ->with('success', 'Pembayaran cicilan Rp ' . number_format($request->jumlah_bayar, 0, ',', '.') . ' berhasil.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal bayar cicilan: ' . $e->getMessage());
        }
    }

    // ================= TRANSAKSI CUSTOMER =================
    public function customerTransactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('installmentPayments')
            ->latest()
            ->get();

        return view('customer.transactions', compact('transactions'));
    }

    // ================= TRANSAKSI ADMIN =================
    public function index()
    {
        $transactions = Transaction::with(['user', 'installmentPayments'])->latest()->get();
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

            if (in_array($transaction->status, ['selesai', 'ditolak'])) {
                return redirect()->back()->with('error', 'Status transaksi ini sudah tidak bisa diubah.');
            }

            // --- LOGIKA JIKA DITOLAK (Balikin Stok) ---
            if ($request->status === 'ditolak') {
                foreach ($transaction->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stok', $item->quantity);
                    }
                }
            }

            // --- LOGIKA JIKA SELESAI (Poin Member) ---
            if ($request->status === 'selesai') {
                if ($user && $user->is_member) {
                    if ($transaction->used_points > 0) {
                        $user->decrement('points', $transaction->used_points);
                    }
                    $earnedPoints = floor($transaction->total_harga / 10000);
                    if ($earnedPoints > 0) {
                        $user->increment('points', $earnedPoints);
                    }
                }
            }

            $transaction->update(['status' => $request->status]);

            DB::commit();
            return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }
}