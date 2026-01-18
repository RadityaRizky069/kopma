@extends('layouts.main')

@section('content')
<div style="padding: 40px; background: #f8fafc; min-height: 100vh; font-family: 'Inter', sans-serif;">
    
    {{-- Header & Tombol Action --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="font-weight: 800; color: #1e293b; font-size: 28px; margin: 0;">
                Laporan Transaksi
            </h2>
            <p style="color: #64748b; margin-top: 5px;">
                Menampilkan data:
                <span style="font-weight: bold; color: #0f172a; text-transform: capitalize;">
                    {{ $type == 'daily' ? 'Harian (Hari Ini)' : 'Bulanan (Bulan Ini)' }}
                </span>
            </p>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <a href="?type=daily"
               style="text-decoration: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; font-size: 14px;
               {{ $type == 'daily'
                    ? 'background: #0f172a; color: white;'
                    : 'background: white; color: #64748b; border: 1px solid #e2e8f0;' }}">
                Harian
            </a>

            <a href="?type=monthly"
               style="text-decoration: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; font-size: 14px;
               {{ $type == 'monthly'
                    ? 'background: #0f172a; color: white;'
                    : 'background: white; color: #64748b; border: 1px solid #e2e8f0;' }}">
                Bulanan
            </a>

            <a href="{{ route('admin.reports.export', ['type' => $type]) }}"
               style="background: #16a34a; color: white; padding: 10px 20px; border-radius: 10px;
               text-decoration: none; font-weight: 600; display: flex; align-items: center;
               gap: 8px; font-size: 14px;">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; text-align: left; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 16px 24px;">Tanggal</th>
                    <th style="padding: 16px 24px;">Customer</th>
                    <th style="padding: 16px 24px;">Produk</th>
                    <th style="padding: 16px 24px;">Jumlah</th>
                    <th style="padding: 16px 24px;">Status</th>
                    <th style="padding: 16px 24px;">Total</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $trx)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 16px 24px;">
                        {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y H:i') }}
                    </td>

                    <td style="padding: 16px 24px; font-weight: 600;">
                        {{ $trx->user_name ?? 'Guest/Dihapus' }}
                    </td>

                    <td style="padding: 16px 24px; color: #64748b;">
                        {{ $trx->product_name ?? '-' }}
                    </td>

                    {{-- INI YANG BARU --}}
                    <td style="padding: 16px 24px; font-weight: 600;">
                        {{ $trx->total_items ?? 0 }} item
                    </td>

                    <td style="padding: 16px 24px;">
                        <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 99px; font-size: 12px;">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>

                    <td style="padding: 16px 24px; font-weight: 700;">
                        Rp {{ number_format($trx->total_price ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 50px; text-align: center;">
                        <p style="color: #64748b;">Belum ada transaksi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
