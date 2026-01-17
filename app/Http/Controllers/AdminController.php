<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $totalProducts  = Product::count();
        $totalCustomers = User::where('role','customer')->count();

        // Aman walau tabel transaksi belum ada
        if (Schema::hasTable('transaksi')) {
            $totalTransactions = DB::table('transaksi')->count();
        } else {
            $totalTransactions = 0;
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalTransactions'
        ));
    }

    // ================= LIST CUSTOMER =================
    public function customers()
    {
        $customers = User::where('role','customer')->get();
        return view('admin.customers', compact('customers'));
    }

    // ================= LAPORAN =================
    public function reports()
    {
        // Mengambil data transaksi yang statusnya 'selesai', dikelompokkan per bulan
        $laporan = Transaction::where('status', 'selesai')
            ->selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, SUM(total_harga) as omzet, COUNT(*) as total_transaksi')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('admin.reports', compact('laporan'));
    }
}
