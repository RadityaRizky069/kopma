@extends('layouts.main')

@section('content')
@php
    use Carbon\Carbon;

    $now   = Carbon::now();
    $type  = $type  ?? 'monthly';
    $month = $month ?? $now->month;
    $year  = $year  ?? $now->year;
    $date  = $date  ?? $now->toDateString();
@endphp

<div style="padding:40px;background:#f8fafc;min-height:100vh;font-family:'Inter',sans-serif;">

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <h2 style="font-weight:800;color:#1e293b;font-size:28px;margin:0;">
                Laporan Transaksi
            </h2>
            <p style="color:#64748b;margin-top:6px;">
                Menampilkan data:
                <strong style="color:#0f172a;">
                    @if($type === 'daily')
                        {{ Carbon::parse($date)->translatedFormat('l, d F Y') }}
                    @elseif($type === 'weekly')
                        Minggu ini
                    @elseif($type === 'monthly')
                        {{ Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
                    @else
                        Tahun {{ $year }}
                    @endif
                </strong>
            </p>
        </div>

        <a href="{{ route('admin.reports.export', request()->all()) }}"
           style="background:#16a34a;color:white;padding:10px 20px;border-radius:10px;
           text-decoration:none;font-weight:600;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET"
          style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;align-items:center;">

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
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}" {{ $month==$m?'selected':'' }}>
                        {{ Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <select name="year" onchange="this.form.submit()"
                    style="padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                @for($y = $now->year; $y >= $now->year-5; $y--)
                    <option value="{{ $y }}" {{ $year==$y?'selected':'' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        @endif

        {{-- TAHUNAN --}}
        @if($type === 'yearly')
            <select name="year" onchange="this.form.submit()"
                    style="padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                @for($y = $now->year; $y >= $now->year-5; $y--)
                    <option value="{{ $y }}" {{ $year==$y?'selected':'' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        @endif
    </form>

    {{-- TABEL --}}
    <div style="background:white;border-radius:16px;box-shadow:0 4px 6px -1px rgba(0,0,0,.05);
                overflow:hidden;border:1px solid #e2e8f0;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                    <th style="padding:16px 24px;">Tanggal</th>
                    <th style="padding:16px 24px;">Customer</th>
                    <th style="padding:16px 24px;">Produk</th>
                    <th style="padding:16px 24px;">Jumlah</th>
                    <th style="padding:16px 24px;">Status</th>
                    <th style="padding:16px 24px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:16px 24px;">
                        {{ Carbon::parse($trx->created_at)->translatedFormat('d M Y H:i') }}
                    </td>
                    <td style="padding:16px 24px;font-weight:600;">
                        {{ $trx->user_name ?? 'Guest/Dihapus' }}
                    </td>
                    <td style="padding:16px 24px;color:#64748b;">
                        {{ $trx->product_name ?? '-' }}
                    </td>
                    <td style="padding:16px 24px;font-weight:600;">
                        {{ $trx->total_items ?? 0 }} item
                    </td>
                    <td style="padding:16px 24px;">
                        <span style="background:#f1f5f9;padding:4px 12px;border-radius:999px;font-size:12px;">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>
                    <td style="padding:16px 24px;font-weight:700;">
                        Rp {{ number_format($trx->total_price ?? 0,0,',','.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:50px;text-align:center;color:#64748b;">
                        Belum ada transaksi untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
