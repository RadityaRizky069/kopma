@extends('layouts.main')

@section('title', 'Laporan Bulanan')

@section('content')

<div class="container" style="padding: 40px 20px;">
    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="font-weight: 800; color: #1e293b; margin: 0;">📊 Laporan Bulanan</h2>
            <p style="color: #64748b; margin-top: 5px;">Rekapitulasi pendapatan koperasi dari transaksi yang selesai.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background: #e2e8f0; color: #475569;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Content --}}
    @if($laporan->isEmpty())
        <div style="text-align: center; padding: 60px; background: white; border-radius: 16px; border: 2px dashed #e2e8f0;">
            <i class="fa-solid fa-chart-pie" style="font-size: 40px; color: #cbd5e1; margin-bottom: 20px;"></i>
            <h3 style="color: #64748b;">Belum ada data laporan</h3>
            <p style="color: #94a3b8;">Data akan muncul setelah ada transaksi yang berstatus "Selesai".</p>
        </div>
    @else
        <div class="card" style="border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; padding: 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th style="text-align: left; padding: 16px 24px; color: #475569; font-weight: 700;">Bulan & Tahun</th>
                        <th style="text-align: center; padding: 16px 24px; color: #475569; font-weight: 700;">Jumlah Transaksi</th>
                        <th style="text-align: right; padding: 16px 24px; color: #475569; font-weight: 700;">Total Omzet</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan as $row)
                        @php
                            $namaBulan = \Carbon\Carbon::createFromDate($row->tahun, $row->bulan)->translatedFormat('F Y');
                        @endphp
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <td style="padding: 20px 24px; color: #1e293b; font-weight: 600;">
                                <i class="fa-regular fa-calendar" style="margin-right: 8px; color: #28a745;"></i> {{ $namaBulan }}
                            </td>
                            <td style="padding: 20px 24px; text-align: center; color: #64748b;">
                                <span style="background: #eff6ff; color: #3b82f6; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                                    {{ $row->total_transaksi }} Pesanan
                                </span>
                            </td>
                            <td style="padding: 20px 24px; text-align: right; font-weight: 800; color: #15803d; font-size: 16px;">
                                Rp {{ number_format($row->omzet, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection