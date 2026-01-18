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

    .installment-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        margin-top: 15px;
    }
    .progress-bar-container {
        height: 8px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin: 10px 0;
    }
    .progress-fill {
        height: 100%;
        background: #22c55e;
        transition: width 0.5s ease;
    }
    .btn-pay {
        background: #22c55e; color: white; padding: 8px 16px; border-radius: 8px;
        text-decoration: none; font-size: 12px; font-weight: 700; transition: 0.3s; display: inline-block;
    }
    .btn-detail-cicilan {
        background: white; color: #64748b; border: 1px solid #cbd5e1; padding: 7px 12px;
        border-radius: 8px; font-size: 11px; font-weight: 600; cursor: pointer; margin-top: 10px;
        transition: 0.2s;
    }
    .btn-detail-cicilan:hover { background: #f1f5f9; color: #1e293b; }
</style>

<div class="history-container">
    <div class="animate__animated animate__fadeInDown">
        <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 10px;">
            <i class="fas fa-history" style="color: #22c55e;"></i> Riwayat Transaksi
        </h2>
        <p style="color: #64748b; margin-bottom: 30px;">Pantau status pesanan dan cicilan kamu di sini.</p>
    </div>

    @if(session('success'))
        <div style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($transactions->isEmpty())
        <div style="text-align:center;padding:60px;background:white;border-radius:20px;border:2px dashed #e2e8f0;">
            <i class="fas fa-receipt" style="font-size: 40px; color: #cbd5e1; margin-bottom: 15px;"></i>
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
                    <span class="badge bg-success">Selesai / Lunas</span>
                @elseif($status == 'ditolak')
                    <span class="badge bg-reject">Ditolak</span>
                @else
                    <span class="badge bg-default">{{ $trx->status }}</span>
                @endif
            </div>

            {{-- BODY --}}
            <div style="display:flex;justify-content:space-between;">
                <div>
                    <small style="color:#64748b;">Metode Pembayaran</small><br>
                    <b style="color:#1e293b;">{{ $trx->metode_pembayaran }}</b>
                </div>
                <div style="text-align:right;">
                    <small style="color:#64748b;">Total Tagihan</small><br>
                    <b style="font-size:18px; color:#1e293b;">
                        Rp {{ number_format($trx->total_harga,0,',','.') }}
                    </b>
                </div>
            </div>

            {{-- ================= LOGIKA CICILAN (NOMOR 2 & 4) ================= --}}
            @if($trx->is_installment)
                @php
                    $persenTerbayar = ($trx->installment_paid / $trx->installment_total) * 100;
                    $sisaBayar = $trx->installment_total - $trx->installment_paid;
                @endphp
                
                <div class="installment-box">
                    <div style="display:flex; justify-content: space-between; align-items: center; font-size: 12px; font-weight: 700;">
                        <span style="color: #475569;"><i class="fas fa-calendar-alt"></i> Progress Cicilan</span>
                        <span style="color: #22c55e;">{{ number_format($persenTerbayar, 0) }}% Terbayar</span>
                    </div>

                    <div class="progress-bar-container">
                        <div class="progress-fill" style="width: {{ $persenTerbayar }}%;"></div>
                    </div>

                    <div style="display:flex; justify-content: space-between; align-items: flex-end; margin-top: 5px;">
                        <div>
                            <small style="font-size: 11px; color: #64748b;">Sisa Tagihan:</small><br>
                            <span style="font-weight: 800; color: #dc2626;">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($sisaBayar > 0 && ($status == 'diproses' || $status == 'menunggu'))
                            <a href="{{ route('transactions.pay', $trx->id) }}" class="btn-pay">
                                <i class="fas fa-wallet"></i> Bayar Cicilan
                            </a>
                        @elseif($sisaBayar <= 0)
                            <span style="color: #16a34a; font-size: 12px; font-weight: 700;">
                                <i class="fas fa-check-double"></i> Cicilan Lunas
                            </span>
                        @endif
                    </div>

                    {{-- TOMBOL LIHAT RIWAYAT (STEP 4) --}}
                    <button class="btn-detail-cicilan" data-bs-toggle="modal" data-bs-target="#modalRiwayat{{ $trx->id }}">
                        <i class="fas fa-receipt"></i> Riwayat Setoran
                    </button>
                </div>

                <div class="modal fade" id="modalRiwayat{{ $trx->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 20px; border: none;">
                            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9;">
                                <h5 class="modal-title" style="font-weight: 800;">Riwayat Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p style="font-size: 13px; color: #64748b;">Rincian setoran untuk <b>{{ $trx->kode_transaksi }}</b></p>
                                
                                <div class="table-responsive">
                                    <table class="table table-sm" style="font-size: 13px;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th class="text-end">Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($trx->installmentPayments as $payment)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i') }}</td>
                                                <td class="text-end font-weight-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-3 text-muted">Belum ada setoran masuk</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: none;">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ================= RIWAYAT POIN ================= --}}
            @if($trx->status === 'selesai' && auth()->user()->is_member)
                <div style="margin-top:15px; padding:12px; border-radius:10px; background:#f0fdf4; border:1px dashed #86efac; font-size:13px; color:#166534;">
                    <b>🎯 Info Poin</b>
                    <ul style="margin:6px 0 0 18px; padding:0;">
                        @if($trx->used_points > 0)
                            <li>Poin digunakan: <b style="color: #dc2626;">-{{ $trx->used_points }}</b></li>
                            <li>Potongan harga: <b>Rp {{ number_format($trx->discount,0,',','.') }}</b></li>
                        @endif
                        @php $earnedPoints = floor($trx->total_harga / 10000); @endphp
                        @if($earnedPoints > 0)
                            <li>Poin yang kamu dapat: <b style="color: #16a34a;">+{{ $earnedPoints }}</b></li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
        @endforeach
    @endif
</div>
@endsection