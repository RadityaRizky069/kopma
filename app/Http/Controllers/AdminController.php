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
        // 1. Ambil semua periode (Bulan & Tahun) yang benar-benar punya data transaksi
        $availablePeriods = DB::table('transaksi')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // 2. Ambil input awal
        $type  = $request->input('type', 'monthly');
        $date  = $request->input('date', now()->toDateString());
        
        // Default Year & Month diambil dari data terbaru yang tersedia
        $latestData = $availablePeriods->first();
        $defaultYear = $latestData ? (int)$latestData->year : now()->year;
        $defaultMonth = $latestData ? (int)$latestData->month : now()->month;

        $year  = (int) $request->input('year', $defaultYear);
        $month = (int) $request->input('month', $defaultMonth);

        // 3. VALIDASI: Pastikan pilihan user ada datanya (Anti-Kosong)
        if ($type === 'monthly') {
            $check = $availablePeriods->where('year', $year)->where('month', $month)->first();
            if (!$check) {
                // Jika user pilih tahun X tapi bulannya ga ada data, 
                // cari bulan terakhir yang tersedia di tahun tersebut
                $lastInYear = $availablePeriods->where('year', $year)->first();
                if ($lastInYear) {
                    $month = (int) $lastInYear->month;
                } else {
                    // Jika tahunnya pun ga ada data, lari ke data terbaru yang pernah ada
                    $year = $defaultYear;
                    $month = $defaultMonth;
                }
            }
        } elseif ($type === 'yearly') {
            $checkYear = $availablePeriods->where('year', $year)->first();
            if (!$checkYear) {
                $year = $defaultYear;
            }
        }

        // 4. Query utama transaksi
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

            // Eksekusi Filter
            if ($type === 'daily') {
                $query->whereDate('transaksi.created_at', $date);
            } elseif ($type === 'weekly') {
                $query->whereBetween('transaksi.created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
            } elseif ($type === 'monthly') {
                $query->whereMonth('transaksi.created_at', $month)
                      ->whereYear('transaksi.created_at', $year);
            } elseif ($type === 'yearly') {
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

        // Filter harus sama dengan view agar data sinkron
        if ($type === 'daily') {
            $query->whereDate('transaksi.created_at', $date);
        } elseif ($type === 'weekly') {
            $query->whereBetween('transaksi.created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($type === 'monthly') {
            $query->whereMonth('transaksi.created_at', $month)
                  ->whereYear('transaksi.created_at', $year);
        } elseif ($type === 'yearly') {
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
            
            // Header CSV
            fputcsv($file, ['Tanggal Transaksi', 'Nama Customer', 'Nama Produk', 'Jumlah Produk', 'Status', 'Total Harga']);

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