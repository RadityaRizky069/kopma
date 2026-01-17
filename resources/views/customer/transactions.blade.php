@extends('layouts.main')

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="container" style="padding: 60px 20px; min-height: 80vh;">
    <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 30px;">📄 Riwayat Transaksi</h2>

    @if(session('success'))
        <div style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($transactions->isEmpty())
        <div style="text-align: center; padding: 60px; background: #f8fafc; border-radius: 16px; border: 2px dashed #e2e8f0;">
            <p style="color: #64748b;">Belum ada riwayat transaksi.</p>
            <a href="/products" style="color: #28a745; font-weight: bold; text-decoration: none;">Belanja Sekarang</a>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach($transactions as $trx)
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 15px;">
                    <div>
                        <div style="font-weight: 700; color: #1e293b;">{{ $trx->kode_transaksi }}</div>
                        <small style="color: #64748b;">{{ $trx->created_at->format('d M Y H:i') }}</small>
                    </div>
                    <div style="text-align: right;">
                        <span style="background: {{ $trx->status == 'menunggu' ? '#fef3c7' : '#dcfce7' }}; 
                                     color: {{ $trx->status == 'menunggu' ? '#d97706' : '#15803d' }}; 
                                     padding: 5px 12px; border-radius: 99px; font-size: 12px; font-weight: 700; text-transform: uppercase;">
                            {{ $trx->status }}
                        </span>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="display: block; font-size: 13px; color: #64748b;">Total Tagihan</span>
                        <span style="font-weight: 800; color: #28a745; font-size: 18px;">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <small style="color: #64748b;">Metode: {{ $trx->metode_pembayaran }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection