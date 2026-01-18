@extends('layouts.main')

@section('title', 'Bayar Cicilan')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container" style="max-width: 500px; margin: 50px auto; padding: 20px;">
    <div style="background: white; padding: 30px; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid #f1f5f9;">
        
        <div style="text-align: center; margin-bottom: 25px;">
            <div style="width: 60px; height: 60px; background: #f0fdf4; color: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 24px;">
                <i class="fas fa-wallet"></i>
            </div>
            <h2 style="font-weight: 800; color: #1e293b; margin: 0;">Bayar Cicilan</h2>
            <p style="color: #64748b; font-size: 14px; margin-top: 5px;">Selesaikan tagihan belanja Anda</p>
        </div>
        
        <div style="background: #f8fafc; padding: 20px; border-radius: 16px; margin-bottom: 25px; border: 1px solid #e2e8f0;">
            <p style="margin: 0; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Kode Transaksi</p>
            <strong style="color: #334155; font-size: 15px;">{{ $transaction->kode_transaksi }}</strong>
            
            <hr style="border: 0; border-top: 1px dashed #cbd5e1; margin: 15px 0;">
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: #64748b; font-size: 14px;">Total Belanja:</span>
                <span style="font-weight: 600; color: #1e293b;">Rp {{ number_format($transaction->installment_total, 0, ',', '.') }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: #16a34a; font-size: 14px;">Sudah Terbayar:</span>
                <span style="font-weight: 600; color: #16a34a;">Rp {{ number_format($transaction->installment_paid, 0, ',', '.') }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-top: 10px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
                <span style="color: #dc2626; font-weight: 700;">Sisa Hutang:</span>
                <span style="font-weight: 800; color: #dc2626; font-size: 18px;">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</span>
            </div>
        </div>

        @if(session('error'))
            <div style="padding: 12px; background: #fef2f2; color: #b91c1c; border-radius: 10px; margin-bottom: 20px; font-size: 13px; border: 1px solid #fca5a5;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('transactions.pay.process', $transaction->id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 10px; font-weight: 700; color: #334155; font-size: 14px;">Nominal Pembayaran</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); font-weight: 700; color: #94a3b8;">Rp</span>
                    <input type="number" name="jumlah_bayar" 
                           value="{{ $transaction->installment_amount }}" 
                           min="1000"
                           max="{{ $sisaBayar }}"
                           style="width: 100%; padding: 15px 15px 15px 45px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 18px; font-weight: 700; color: #1e293b; transition: all 0.3s;" 
                           onfocus="this.style.borderColor='#22c55e'; this.style.boxShadow='0 0 0 4px rgba(34, 197, 94, 0.1)';"
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                           required>
                </div>
                <div style="margin-top: 10px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-info-circle" style="color: #3b82f6; font-size: 12px;"></i>
                    <small style="color: #64748b;">Saran cicilan: <b>Rp {{ number_format($transaction->installment_amount, 0, ',', '.') }}</b></small>
                </div>
            </div>

            <button type="submit" 
                    style="width: 100%; background: #22c55e; color: white; border: none; padding: 16px; border-radius: 14px; font-weight: 700; cursor: pointer; font-size: 16px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);"
                    onmouseover="this.style.background='#16a34a'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.background='#22c55e'; this.style.transform='translateY(0)';"
                    onclick="return confirm('Apakah nominal yang dimasukkan sudah benar?')">
                Konfirmasi Pembayaran
            </button>
            
            <a href="{{ route('customer.transactions') }}" 
               style="display: block; text-align: center; margin-top: 20px; color: #94a3b8; text-decoration: none; font-weight: 600; font-size: 14px; transition: color 0.2s;"
               onmouseover="this.style.color='#64748b'"
               onmouseout="this.style.color='#94a3b8'">
                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
            </a>
        </form>
    </div>
</div>
@endsection