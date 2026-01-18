    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\Product;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\DB;

    class AdminController extends Controller
    {
        // ================= DASHBOARD =================
        public function dashboard()
        {
            $totalProducts      = Schema::hasTable('produk') ? DB::table('produk')->count() : 0;
            $totalCustomers     = User::where('role', 'customer')->count();
            $totalTransactions  = Schema::hasTable('transaksi') ? DB::table('transaksi')->count() : 0;

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

        // ================= LAPORAN (VIEW) =================
        public function reports(Request $request)
        {
            $type = $request->input('type', 'monthly');

            if (!Schema::hasTable('transaksi')) {
                $transactions = collect();
            } else {
                // === QUERY DENGAN JEMBATAN (DETAIL_TRANSAKSI) ===
                $query = DB::table('transaksi')
                    // 1. Join ke User
                    ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
                    
                    // 2. Join ke Detail Transaksi (Jembatan)
                    // Asumsi: tabel 'detail_transaksi' punya kolom 'transaksi_id'
                    ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
                    
                    // 3. Join dari Detail ke Produk
                    // Asumsi: tabel 'detail_transaksi' punya kolom 'produk_id'
                    ->leftJoin('produk', 'detail_transaksi.produk_id', '=', 'produk.id')

                    ->select(
                        'transaksi.*', 
                        'users.name as user_name',
                        // Ambil nama produk dari tabel produk
                        'produk.nama_produk as product_name',
                        // Pastikan harga diambil dari transaksi (total_price)
                        'transaksi.total_price'
                    )
                    // Group By untuk menghindari duplikat jika 1 transaksi ada banyak barang
                    ->groupBy('transaksi.id') 
                    ->orderBy('transaksi.created_at', 'desc');

                if ($type == 'daily') {
                    $query->whereDate('transaksi.created_at', date('Y-m-d'));
                } elseif ($type == 'monthly') {
                    $query->whereMonth('transaksi.created_at', date('m'))
                        ->whereYear('transaksi.created_at', date('Y'));
                }

                $transactions = $query->get();
            }

            return view('admin.transactions.reports', compact('transactions', 'type'));
        }

        // ================= EXPORT EXCEL (NATIVE CSV) =================
        public function exportReports(Request $request)
        {
            $type = $request->input('type', 'monthly');
            $fileName = 'laporan-' . $type . '-' . date('d-m-Y') . '.csv';

            if (!Schema::hasTable('transaksi')) {
                return redirect()->back()->with('error', 'Tabel transaksi belum ada');
            }

            // Copy Query yang sama persis dengan di atas
            $query = DB::table('transaksi')
                ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
                ->leftJoin('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
                ->leftJoin('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
                ->select(
                    'transaksi.created_at',
                    'users.name as user_name',
                    'produk.nama_produk as product_name',
                    'transaksi.status',
                    'transaksi.total_price'
                )
                ->groupBy('transaksi.id')
                ->orderBy('transaksi.created_at', 'desc');

            if ($type == 'daily') {
                $query->whereDate('transaksi.created_at', date('Y-m-d'));
            } elseif ($type == 'monthly') {
                $query->whereMonth('transaksi.created_at', date('m'))
                    ->whereYear('transaksi.created_at', date('Y'));
            }

            $transactions = $query->get();

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $callback = function() use ($transactions) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Tanggal Transaksi', 'Nama Customer', 'Nama Produk', 'Status', 'Total Harga']);

                foreach ($transactions as $row) {
                    fputcsv($file, [
                        $row->created_at,
                        $row->user_name ?? 'Guest/Dihapus',
                        $row->product_name ?? 'Item Dihapus',
                        $row->status,
                        $row->total_price
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }