<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;

class AdminController extends Controller
{
    // Dashboard admin
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCustomers = User::where('role','customer')->count();
        $totalTransactions = Transaction::count();

        return view('admin.dashboard', compact('totalProducts','totalCustomers','totalTransactions'));
    }

    // Daftar customer
    public function customers()
    {
        $customers = User::where('role','customer')->get();
        return view('admin.customers', compact('customers'));
    }

    // Laporan penjualan
    public function reports(Request $request)
    {
        $type = $request->input('type','daily'); // daily / monthly

        if($type == 'daily'){
            $transactions = Transaction::whereDate('created_at', now()->format('Y-m-d'))->get();
        } else {
            $transactions = Transaction::whereMonth('created_at', now()->month)->get();
        }

        return view('admin.reports', compact('transactions','type'));
    }
}
