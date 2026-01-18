<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $totalProducts = Schema::hasTable('produk')
            ? DB::table('produk')->count()
            : 0;

        $totalCustomers = User::where('role', 'customer')->count();

        $totalTransactions = Schema::hasTable('transaksi')
            ? DB::table('transaksi')->count()
            : 0;

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalTransactions'
        ));
    }

    // ================= LIST CUSTOMER =================
    public function customers()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.customers', compact('customers'));
    }

    // ================= LAPORAN =================
    public function reports(Request $request)
    {
        $type  = $request->input('type', 'monthly');
        $month = (int) $request->input('month', now()->month);
        $year  = (int) $request->input('year', now()->year);
        $date  = $request->input('date', now()->toDateString());

        // ================= AMBIL BULAN & TAHUN YANG ADA DATA =================
        $availablePeriods = DB::table('transaksi')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // ================= VALIDASI BULAN (ANTI ERROR) =================
        if ($type === 'monthly') {
            $isValid = $availablePeriods
                ->where('year', $year)
                ->where('month', $month)
                ->count();

            if (!$isValid) {
                // fallback ke bulan terbaru yang ada data
                $latest = $availablePeriods->first();
                if ($latest) {
                    $month = (int) $latest->month;
                    $year  = (int) $latest->year;
                }
            }
        }

        if (!Schema::hasTable('transaksi')) {
            $transactions = collect();
        } else {

            $query = DB::table('transaksi')
                ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
                ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaction_id')
                ->leftJoin('produk', 'detail_transaksi.product_id', '=', 'produk.id')
                ->select(
                    'transaksi.id',
                    'transaksi.created_at',
                    'transaksi.status',
                    'users.name as user_name',
                    DB::raw('GROUP_CONCAT(produk.nama_produk SEPARATOR ", ") as product_name'),
                    DB::raw('SUM(detail_transaksi.quantity) as total_items'),
                    'transaksi.total_harga as total_price'
                )
                ->groupBy(
                    'transaksi.id',
                    'transaksi.created_at',
                    'transaksi.status',
                    'users.name',
                    'transaksi.total_harga'
                )
                ->orderBy('transaksi.created_at', 'desc');

            // ================= FILTER =================
            if ($type === 'daily') {
                $query->whereDate('transaksi.created_at', $date);
            }
            elseif ($type === 'weekly') {
                $query->whereBetween('transaksi.created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
            }
            elseif ($type === 'monthly') {
                $query->whereMonth('transaksi.created_at', $month)
                      ->whereYear('transaksi.created_at', $year);
            }
            elseif ($type === 'yearly') {
                $query->whereYear('transaksi.created_at', $year);
            }

            $transactions = $query->get();
        }

        return view('admin.transactions.reports', compact(
            'transactions',
            'type',
            'month',
            'year',
            'date',
            'availablePeriods'
        ));
    }

    // ================= EXPORT CSV =================
    public function exportReports(Request $request)
    {
        $type  = $request->input('type', 'monthly');
        $month = (int) $request->input('month', now()->month);
        $year  = (int) $request->input('year', now()->year);
        $date  = $request->input('date', now()->toDateString());

        $fileName = 'laporan-' . $type . '-' . date('d-m-Y') . '.csv';

        if (!Schema::hasTable('transaksi')) {
            return redirect()->back()->with('error', 'Tabel transaksi belum ada');
        }

        $query = DB::table('transaksi')
            ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
            ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaction_id')
            ->leftJoin('produk', 'detail_transaksi.product_id', '=', 'produk.id')
            ->select(
                'transaksi.created_at',
                'users.name as user_name',
                DB::raw('GROUP_CONCAT(produk.nama_produk SEPARATOR ", ") as product_name'),
                DB::raw('SUM(detail_transaksi.quantity) as total_items'),
                'transaksi.status',
                'transaksi.total_harga as total_price'
            )
            ->groupBy(
                'transaksi.id',
                'transaksi.created_at',
                'users.name',
                'transaksi.status',
                'transaksi.total_harga'
            )
            ->orderBy('transaksi.created_at', 'desc');

        // FILTER SAMA DENGAN VIEW
        if ($type === 'daily') {
            $query->whereDate('transaksi.created_at', $date);
        }
        elseif ($type === 'weekly') {
            $query->whereBetween('transaksi.created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }
        elseif ($type === 'monthly') {
            $query->whereMonth('transaksi.created_at', $month)
                  ->whereYear('transaksi.created_at', $year);
        }
        elseif ($type === 'yearly') {
            $query->whereYear('transaksi.created_at', $year);
        }

        $transactions = $query->get();

        $headers = [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate",
            "Expires"             => "0",
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Tanggal Transaksi',
                'Nama Customer',
                'Nama Produk',
                'Jumlah Produk',
                'Status',
                'Total Harga'
            ]);

            foreach ($transactions as $row) {
                fputcsv($file, [
                    $row->created_at,
                    $row->user_name ?? 'Guest',
                    $row->product_name ?? '-',
                    $row->total_items ?? 0,
                    $row->status,
                    $row->total_price
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
