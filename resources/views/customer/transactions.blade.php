@extends('layouts.main')

@section('title', 'Riwayat Transaksi')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* Styling khusus halaman ini agar rapi */
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

    /* Warna Status */
    .bg-waiting { background: #fffbeb; color: #b45309; border: 1px solid #fcd34d; }
    .bg-process { background: #eff6ff; color: #0369a1; border: 1px solid #bae6fd; }
    .bg-success { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
    .bg-reject  { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; }
    .bg-default { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; } /* Warna cadangan */

    .btn-shop {
        display: inline-block;
        margin-top: 15px;
        padding: 12px 25px;
        background: #22c55e;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-shop:hover { background: #166534; color: white; }
</style>

<div class="history-container">
    <div class="animate__animated animate__fadeInDown">
        <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 10px;">
            <i class="fas fa-history" style="color: #22c55e;"></i> Riwayat Transaksi
        </h2>
        <p style="color: #64748b; margin-bottom: 30px;">Pantau status pesanan kamu di sini.</p>
    </div>

    @if(session('success'))
        <div class="animate__animated animate__fadeIn" style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #86efac; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($transactions->isEmpty())
        <div class="animate__animated animate__fadeInUp" style="text-align: center; padding: 60px; background: white; border-radius: 20px; border: 2px dashed #e2e8f0;">
            <i class="fas fa-shopping-basket" style="font-size: 50px; color: #cbd5e1; margin-bottom: 20px;"></i>
            <h3 style="color: #475569; font-weight: 700;">Belum ada riwayat transaksi.</h3>
            <p style="color: #94a3b8;">Yuk mulai belanja produk kebutuhanmu sekarang!</p>
            <a href="{{ route('products.index') }}" class="btn-shop">
                <i class="fas fa-shopping-cart"></i> Belanja Sekarang
            </a>
        </div>
    @else
        <div class="animate__animated animate__fadeInUp">
            @foreach($transactions as $trx)
            <div class="trx-card">
                {{-- Header Kartu --}}
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 15px; margin-bottom: 15px;">
                    <div>
                        <div style="font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 5px;">
                            <i class="far fa-calendar-alt"></i> {{ $trx->created_at->format('d M Y') }}
                            <span style="color: #cbd5e1;">|</span>
                            {{ $trx->created_at->format('H:i') }} WIB
                        </div>
                        <div style="font-weight: 800; color: #334155; margin-top: 5px; font-size: 16px;">
                            {{ $trx->kode_transaksi }}
                        </div>
                    </div>
                    
                    {{-- LOGIKA STATUS WARNA-WARNI (ANTI-GAGAL) --}}
                    <div>
                        {{-- 1. Ambil status, ubah jadi huruf kecil semua --}}
                        @php $status = strtolower($trx->status); @endphp

                        @if($status == 'menunggu')
                            <span class="badge bg-waiting">
                                <i class="fas fa-clock"></i> Menunggu
                            </span>
                        @elseif($status == 'diproses')
                            <span class="badge bg-process">
                                <i class="fas fa-spinner fa-spin"></i> Diproses
                            </span>
                        @elseif($status == 'selesai')
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        @elseif($status == 'ditolak')
                            <span class="badge bg-reject">
                                <i class="fas fa-times-circle"></i> Ditolak
                            </span>
                        @else
                            {{-- CADANGAN: Jika status tidak dikenali, tetap munculkan teks aslinya --}}
                            <span class="badge bg-default">
                                <i class="fas fa-info-circle"></i> {{ $trx->status }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Body Kartu --}}
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <span style="display: block; font-size: 12px; color: #94a3b8; margin-bottom: 3px;">Metode Pembayaran</span>
                        <span style="font-weight: 600; color: #475569; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-size: 13px;">
                            {{ $trx->metode_pembayaran }}
                        </span>
                    </div>
                    <div style="text-align: right;">
                        <span style="display: block; font-size: 12px; color: #94a3b8; margin-bottom: 3px;">Total Tagihan</span>
                        <span style="font-weight: 800; color: #0f172a; font-size: 20px;">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection