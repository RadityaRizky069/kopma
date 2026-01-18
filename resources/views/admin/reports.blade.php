@extends('layouts.main')

@section('title', 'Laporan Transaksi')

@section('content')
@php
    use Carbon\Carbon;
    $now = Carbon::now();
@endphp

<div class="container" style="padding:40px 20px;">

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
        <div>
            <h2 style="font-weight:800;color:#1e293b;margin:0;">📊 Laporan Transaksi</h2>
            <p style="color:#64748b;margin-top:6px;">
                Menampilkan data:
                <strong>
                    @if($type === 'daily')
                        {{ Carbon::parse($date)->translatedFormat('l, d F Y') }}
                    @elseif($type === 'weekly')
                        Minggu ini
                    @elseif($type === 'monthly')
                        {{ Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}
                    @else
                        Tahun {{ $year }}
                    @endif
                </strong>
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn"
           style="background:#e2e8f0;color:#475569;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET"
          style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:25px;align-items:center;">

        {{-- TYPE --}}
        <select name="type" onchange="this.form.submit()"
                style="padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;">
            <option value="daily" {{ $type=='daily'?'selected':'' }}>Harian</option>
            <option value="weekly" {{ $type=='weekly'?'selected':'' }}>Mingguan</option>
            <option value="monthly" {{ $type=='monthly'?'selected':'' }}>Bulanan</option>
            <option value="yearly" {{ $type=='yearly'?'selected':'' }}>Tahunan</option>
        </select>

        {{-- HARIAN --}}
        @if($type === 'daily')
            <input type="date" name="date" value="{{ $date }}"
                   onchange="this.form.submit()"
                   style="padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;">
        @endif

        {{-- BULANAN --}}
        @if($type === 'monthly')
            <select name="month" onchange="this.form.submit()"
                    style="padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                @foreach($availablePeriods->where('year', $year) as $p)
                    <option value="{{ $p->month }}"
                        {{ $month == $p->month ? 'selected' : '' }}>
                        {{ Carbon::createFromDate($p->year, $p->month, 1)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>

            <select name="year" onchange="this.form.submit()"
                    style="padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                @foreach($availablePeriods->pluck('year')->unique() as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        @endif

        {{-- TAHUNAN --}}
        @if($type === 'yearly')
            <select name="year" onchange="this.form.submit()"
                    style="padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                @foreach($availablePeriods->pluck('year')->unique() as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        @endif

        {{-- EXPORT --}}
        <a href="{{ route('admin.reports.export', request()->all()) }}"
           class="btn"
           style="background:#16a34a;color:white;">
            <i class="fa-solid fa-file-excel"></i> Export Excel
        </a>
    </form>

    {{-- TABEL --}}
    @if($transactions->isEmpty())
        <div style="text-align:center;padding:60px;background:white;border-radius:16px;
                    border:2px dashed #e2e8f0;">
            <i class="fa-solid fa-inbox" style="font-size:40px;color:#cbd5e1;"></i>
            <h3 style="color:#64748b;margin-top:15px;">Tidak ada transaksi</h3>
            <p style="color:#94a3b8;">Belum ada data untuk periode ini.</p>
        </div>
    @else
        <div class="card" style="border:none;box-shadow:0 4px 6px -1px rgba(0,0,0,.05);">
            <table style="width:100%;border-collapse:collapse;">
                <thead style="background:#f8fafc;border-bottom:2px solid #e2e8f0;">
                    <tr>
                        <th style="padding:14px 20px;text-align:left;">Tanggal</th>
                        <th style="padding:14px 20px;text-align:left;">Customer</th>
                        <th style="padding:14px 20px;text-align:left;">Produk</th>
                        <th style="padding:14px 20px;text-align:center;">Jumlah</th>
                        <th style="padding:14px 20px;text-align:center;">Status</th>
                        <th style="padding:14px 20px;text-align:right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:14px 20px;">
                                {{ Carbon::parse($trx->created_at)->translatedFormat('d M Y H:i') }}
                            </td>
                            <td style="padding:14px 20px;font-weight:600;">
                                {{ $trx->user_name ?? 'Guest' }}
                            </td>
                            <td style="padding:14px 20px;color:#64748b;">
                                {{ $trx->product_name ?? '-' }}
                            </td>
                            <td style="padding:14px 20px;text-align:center;">
                                {{ $trx->total_items }} item
                            </td>
                            <td style="padding:14px 20px;text-align:center;">
                                <span style="background:#f1f5f9;padding:4px 12px;
                                             border-radius:20px;font-size:12px;">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td style="padding:14px 20px;text-align:right;font-weight:700;color:#15803d;">
                                Rp {{ number_format($trx->total_price,0,',','.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
