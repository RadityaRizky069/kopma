@extends('layouts.main')

@section('title', 'Laporan Transaksi')

@section('content')
@php
use Carbon\Carbon;
$now = Carbon::now();
@endphp

<div class="container" style="padding:40px 20px; max-width: 1200px; margin: auto; font-family: 'Inter', sans-serif;">

{{-- HEADER --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px; gap: 15px; flex-wrap: wrap;">
    <div>
        <h2 style="font-weight:800;color:#1e293b;margin:0; font-size: 1.75rem; letter-spacing: -0.025em;">📊 Laporan Transaksi</h2>
        <p style="color:#64748b;margin-top:8px; font-size: 15px;">
            Periode: 
            <span style="color: #0f172a; font-weight: 700; background: #f1f5f9; padding: 4px 10px; border-radius: 6px;">
                @if($type === 'daily')
                    {{ Carbon::parse($date)->translatedFormat('l, d F Y') }}
                @elseif($type === 'weekly')
                    Minggu Ini ({{ $now->startOfWeek()->translatedFormat('d M') }} - {{ $now->endOfWeek()->translatedFormat('d M') }})
                @elseif($type === 'monthly')
                    {{ Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}
                @else
                    Tahun {{ $year }}
                @endif
            </span>
        </p>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="btn" 
       style="background:#ffffff; color:#475569; border: 1px solid #e2e8f0; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <i class="fa-solid fa-arrow-left" style="margin-right: 8px;"></i> Dashboard
    </a>
</div>

{{-- FILTER FORM CARD --}}
<div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #e2e8f0; margin-bottom: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
    <form method="GET" style="display:flex; gap:16px; flex-wrap:wrap; align-items:flex-end;">
        
        {{-- PILIH TIPE --}}
        <div style="display: flex; flex-direction: column; gap: 8px; flex: 1; min-width: 160px;">
            <label style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Rentang Waktu</label>
            <select name="type" onchange="this.form.submit()" 
                    style="padding:10px 14px;border-radius:10px;border:1px solid #cbd5e1; background-color: #f8fafc; font-weight: 500; color: #1e293b;">
                <option value="daily" {{ $type=='daily'?'selected':'' }}>📅 Harian</option>
                <option value="weekly" {{ $type=='weekly'?'selected':'' }}>🗓️ Mingguan</option>
                <option value="monthly" {{ $type=='monthly'?'selected':'' }}>📁 Bulanan</option>
                <option value="yearly" {{ $type=='yearly'?'selected':'' }}>📊 Tahunan</option>
            </select>
        </div>

        {{-- INPUT HARIAN --}}
        @if($type === 'daily')
            <div style="display: flex; flex-direction: column; gap: 8px; flex: 1; min-width: 160px;">
                <label style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Pilih Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
                       style="padding:9px 14px;border-radius:10px;border:1px solid #cbd5e1; font-weight: 500;">
            </div>
        @endif

        {{-- INPUT TAHUN --}}
        @if($type === 'monthly' || $type === 'yearly')
            <div style="display: flex; flex-direction: column; gap: 8px; flex: 0.5; min-width: 100px;">
                <label style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Tahun</label>
                <select name="year" onchange="this.form.submit()" 
                        style="padding:10px 14px;border-radius:10px;border:1px solid #cbd5e1; font-weight: 500;">
                    @foreach($availablePeriods->pluck('year')->unique() as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        {{-- INPUT BULAN --}}
        @if($type === 'monthly')
            <div style="display: flex; flex-direction: column; gap: 8px; flex: 1; min-width: 160px;">
                <label style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Bulan</label>
                <select name="month" onchange="this.form.submit()" 
                        style="padding:10px 14px;border-radius:10px;border:1px solid #cbd5e1; font-weight: 500;">
                    @foreach($availablePeriods->where('year', $year) as $p)
                        <option value="{{ $p->month }}" {{ $month == $p->month ? 'selected' : '' }}>
                            {{ Carbon::createFromDate($p->year, $p->month, 1)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        {{-- TOMBOL EXPORT --}}
        <div style="margin-left: auto;">
            <a href="{{ route('admin.reports.export', request()->all()) }}" 
               class="btn" style="background:#16a34a; color:white; padding: 11px 24px; border-radius: 10px; text-decoration: none; font-weight: 700; display: inline-block; font-size: 14px; transition: all 0.2s; box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);">
                <i class="fa-solid fa-file-csv" style="margin-right: 8px;"></i> Export CSV
            </a>
        </div>
    </form>
</div>

{{-- DATA TABLE CARD --}}
@if($transactions->isEmpty())
    <div style="text-align:center;padding:100px 20px;background:white;border-radius:20px; border:2px dashed #e2e8f0;">
        <div style="background: #f8fafc; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i class="fa-solid fa-magnifying-glass" style="font-size:40px;color:#cbd5e1;"></i>
        </div>
        <h3 style="color:#1e293b; margin:0; font-weight: 800; font-size: 1.25rem;">Tidak Ada Data</h3>
        <p style="color:#64748b; margin-top:10px; font-size: 15px;">Kami tidak menemukan transaksi untuk filter yang Anda pilih.</p>
    </div>
@else
    <div style="background:white; border-radius:20px; border:1px solid #e2e8f0; overflow:hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
        <div style="overflow-x: auto;">
            <table style="width:100%;border-collapse:collapse; min-width: 900px;">
                <thead>
                    <tr style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                        <th style="padding:20px;text-align:left; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800;">Waktu</th>
                        <th style="padding:20px;text-align:left; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800;">Customer</th>
                        <th style="padding:20px;text-align:left; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800;">Produk</th>
                        <th style="padding:20px;text-align:center; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800;">Qty</th>
                        <th style="padding:20px;text-align:center; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800;">Status</th>
                        <th style="padding:20px;text-align:right; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                        <tr style="border-bottom:1px solid #f1f5f9; transition: background 0.1s;" onmouseover="this.style.backgroundColor='#fcfcfc'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding:18px 20px;">
                                <div style="color: #1e293b; font-weight: 600; font-size: 14px;">{{ Carbon::parse($trx->created_at)->translatedFormat('d M Y') }}</div>
                                <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">{{ Carbon::parse($trx->created_at)->format('H:i') }} WIB</div>
                            </td>
                            <td style="padding:18px 20px;">
                                <div style="font-weight:700; color: #0f172a; font-size: 14px;">{{ $trx->user_name ?? 'Guest User' }}</div>
                            </td>
                            <td style="padding:18px 20px; color:#475569; font-size: 13px; line-height: 1.5;">
                                {{ Str::limit($trx->product_name ?? '-', 60) }}
                            </td>
                            <td style="padding:18px 20px;text-align:center; font-weight: 700; color: #1e293b; font-size: 14px;">
                                {{ $trx->total_items }}
                            </td>
                            <td style="padding:18px 20px;text-align:center;">
                                @php
                                    $status = strtolower($trx->status);
                                    $badge = match($status) {
                                        'completed', 'success', 'berhasil' => ['bg' => '#dcfce7', 'text' => '#166534', 'label' => 'Berhasil'],
                                        'pending', 'proses' => ['bg' => '#fef9c3', 'text' => '#854d0e', 'label' => 'Proses'],
                                        'cancelled', 'batal', 'failed' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'Batal'],
                                        default => ['bg' => '#f1f5f9', 'text' => '#475569', 'label' => $trx->status]
                                    };
                                @endphp
                                <span style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }}; padding:6px 14px; border-radius:20px; font-size:11px; font-weight: 800; text-transform: uppercase; display: inline-block;">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td style="padding:18px 20px;text-align:right;font-weight:800;color:#16a34a; font-size: 15px;">
                                Rp{{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc;">
                        <td colspan="5" style="padding: 24px; text-align: right; color: #64748b; font-weight: 700; font-size: 14px;">TOTAL PENDAPATAN</td>
                        <td style="padding: 24px; text-align: right; color: #15803d; font-weight: 900; font-size: 1.35rem; border-left: 1px solid #e2e8f0;">
                            Rp{{ number_format($transactions->sum('total_price'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endif


</div>
@endsection