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
    public function reports(Request $request)
    {
        $type = $request->input('type','daily');

        if (!Schema::hasTable('transaksi')) {
            $transactions = collect();
        } else {
            if($type == 'daily'){
                $transactions = DB::table('transaksi')
                    ->whereDate('created_at', date('Y-m-d'))
                    ->get();
            } else {
                $transactions = DB::table('transaksi')
                    ->whereMonth('created_at', date('m'))
                    ->get();
            }
        }

        return view('admin.reports', compact('transactions','type'));
    }
}
