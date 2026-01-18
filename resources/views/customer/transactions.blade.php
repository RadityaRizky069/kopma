@extends('layouts.main')

@section('title', 'Riwayat Transaksi')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .history-container {
        padding: 40px 20px;
        min-height: 80vh;
        max-width: 800px;
        margin: 0 auto;
        font-family: 'Inter', sans-serif;
    }

    .trx-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .trx-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .bg-waiting { background: #fffbeb; color: #b45309; border: 1px solid #fcd34d; }
    .bg-process { background: #eff6ff; color: #0369a1; border: 1px solid #bae6fd; }
    .bg-success { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
    .bg-reject  { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; }
    .bg-default { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
</style>

<div class="history-container">
    <div class="animate__animated animate__fadeInDown">
        <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 10px;">
            <i class="fas fa-history" style="color: #22c55e;"></i> Riwayat Transaksi
        </h2>
        <p style="color: #64748b; margin-bottom: 30px;">Pantau status pesanan kamu di sini.</p>
    </div>

    @if($transactions->isEmpty())
        <div style="text-align:center;padding:60px;background:white;border-radius:20px;border:2px dashed #e2e8f0;">
            <h3>Belum ada transaksi</h3>
        </div>
    @else
        @foreach($transactions as $trx)
        <div class="trx-card">
            {{-- HEADER --}}
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px dashed #e2e8f0;padding-bottom:15px;margin-bottom:15px;">
                <div>
                    <div style="font-size:13px;color:#64748b;">
                        {{ $trx->created_at->format('d M Y H:i') }} WIB
                    </div>
                    <div style="font-weight:800;color:#334155;margin-top:5px;">
                        {{ $trx->kode_transaksi }}
                    </div>
                </div>

                @php $status = strtolower($trx->status); @endphp
                @if($status == 'menunggu')
                    <span class="badge bg-waiting">Menunggu</span>
                @elseif($status == 'diproses')
                    <span class="badge bg-process">Diproses</span>
                @elseif($status == 'selesai')
                    <span class="badge bg-success">Selesai</span>
                @elseif($status == 'ditolak')
                    <span class="badge bg-reject">Ditolak</span>
                @else
                    <span class="badge bg-default">{{ $trx->status }}</span>
                @endif
            </div>

            {{-- BODY --}}
            <div style="display:flex;justify-content:space-between;">
                <div>
                    <small>Metode Pembayaran</small><br>
                    <b>{{ $trx->metode_pembayaran }}</b>
                </div>
                <div style="text-align:right;">
                    <small>Total Tagihan</small><br>
                    <b style="font-size:18px;">
                        Rp {{ number_format($trx->total_harga,0,',','.') }}
                    </b>
                </div>
            </div>

            {{-- ================= RIWAYAT POIN (TAMBAHAN) ================= --}}
            @if($trx->status === 'selesai' && auth()->user()->is_member)
                <div style="
                    margin-top:15px;
                    padding:12px;
                    border-radius:10px;
                    background:#f0fdf4;
                    border:1px dashed #86efac;
                    font-size:13px;
                    color:#166534;
                ">
                    <b>🎯 Riwayat Poin</b>
                    <ul style="margin:6px 0 0 18px;">
                        @if($trx->used_points > 0)
                            <li>Poin digunakan: <b>-{{ $trx->used_points }}</b></li>
                            <li>Potongan: <b>Rp {{ number_format($trx->discount,0,',','.') }}</b></li>
                        @endif

                        @php
                            $earnedPoints = floor($trx->total_harga / 10000);
                        @endphp

                        @if($earnedPoints > 0)
                            <li>Poin didapat: <b>+{{ $earnedPoints }}</b></li>
                        @endif
                    </ul>
                </div>
            @endif
            {{-- =========================================================== --}}
        </div>
        @endforeach
    @endif
</div>
@endsection
