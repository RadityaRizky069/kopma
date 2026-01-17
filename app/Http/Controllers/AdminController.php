<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /* =====================
       DASHBOARD ADMIN
    ====================== */
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // Cek apakah tabel transactions sudah ada
        if (Schema::hasTable('transactions')) {
            $totalTransactions = DB::table('transactions')->count();
        } else {
            $totalTransactions = 0;
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalTransactions'
        ));
    }


    /* =====================
       DAFTAR CUSTOMER
    ====================== */
    public function customers()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.customers', compact('customers'));
    }


    /* =====================
       LAPORAN PENJUALAN
    ====================== */
    public function reports(Request $request)
    {
        $type = $request->input('type', 'daily'); 
        $transactions = [];

        // Cek dulu apakah tabel tersedia
        if (Schema::hasTable('transactions')) {

            if ($type == 'daily') {
                $transactions = DB::table('transactions')
                    ->whereDate('created_at', now()->format('Y-m-d'))
                    ->get();
            } else {
                $transactions = DB::table('transactions')
                    ->whereMonth('created_at', now()->month)
                    ->get();
            }
        }

        return view('admin.reports', compact('transactions', 'type'));
    }
}
