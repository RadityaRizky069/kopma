@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div style="padding: 40px; background: #f8fafc; min-height: 100vh; font-family: 'Inter', sans-serif;">
    
    <div style="margin-bottom: 40px;" class="animate__animated animate__fadeIn">
        <h2 style="font-weight: 800; color: #1e293b; font-size: 32px; margin: 0; letter-spacing: -1px;">
            Dashboard Overview
        </h2>
        <p style="color: #64748b; margin-top: 5px; font-size: 16px;">
            Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Berikut adalah ringkasan operasional KOPMA.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 40px;">
        
        <div style="background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; position: relative; overflow: hidden;" class="animate__animated animate__zoomIn">
            <div style="position: absolute; right: -15px; top: -15px; width: 110px; height: 110px; background: #dcfce7; border-radius: 50%; opacity: 0.6;"></div>
            <div style="display: flex; align-items: center; gap: 20px; position: relative;">
                <div style="background: #22c55e; color: white; width: 64px; height: 64px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 10px 15px rgba(34,197,94,0.3);">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div>
                    <p style="margin: 0; color: #64748b; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Produk</p>
                    <h3 style="margin: 5px 0 0; font-size: 36px; font-weight: 800; color: #0f172a;">{{ $totalProducts }}</h3>
                </div>
            </div>
            <div style="margin-top: 25px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                <a href="{{ route('admin.products.index') }}" style="text-decoration: none; color: #22c55e; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                    Kelola Katalog <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                </a>
            </div>
        </div>

        <div style="background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; position: relative; overflow: hidden;" class="animate__animated animate__zoomIn animate__delay-1s">
            <div style="position: absolute; right: -15px; top: -15px; width: 110px; height: 110px; background: #e0f2fe; border-radius: 50%; opacity: 0.6;"></div>
            <div style="display: flex; align-items: center; gap: 20px; position: relative;">
                <div style="background: #0ea5e9; color: white; width: 64px; height: 64px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 10px 15px rgba(14,165,233,0.3);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <p style="margin: 0; color: #64748b; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Customer</p>
                    <h3 style="margin: 5px 0 0; font-size: 36px; font-weight: 800; color: #0f172a;">{{ $totalCustomers }}</h3>
                </div>
            </div>
            <div style="margin-top: 25px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                <a href="{{ url('admin/customers') }}" style="text-decoration: none; color: #0ea5e9; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                    Lihat Member <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                </a>
            </div>
        </div>

        <div style="background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; position: relative; overflow: hidden;" class="animate__animated animate__zoomIn animate__delay-2s">
            <div style="position: absolute; right: -15px; top: -15px; width: 110px; height: 110px; background: #fef3c7; border-radius: 50%; opacity: 0.6;"></div>
            <div style="display: flex; align-items: center; gap: 20px; position: relative;">
                <div style="background: #f59e0b; color: white; width: 64px; height: 64px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 10px 15px rgba(245,158,11,0.3);">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <p style="margin: 0; color: #64748b; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Transaksi</p>
                    <h3 style="margin: 5px 0 0; font-size: 36px; font-weight: 800; color: #0f172a;">{{ $totalTransactions }}</h3>
                </div>
            </div>
            <div style="margin-top: 25px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                <a href="{{ url('admin/reports') }}" style="text-decoration: none; color: #f59e0b; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                    Laporan Penjualan <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                </a>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;" class="animate__animated animate__fadeInUp animate__delay-3s">
        <div style="background: white; padding: 35px; border-radius: 28px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <h4 style="margin: 0 0 25px 0; font-size: 20px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-bolt" style="color: #f59e0b;"></i> Akses Cepat
            </h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <a href="{{ route('admin.products.create') }}" style="display: flex; flex-direction: column; gap: 10px; padding: 25px; border: 2px dashed #e2e8f0; border-radius: 20px; text-decoration: none; transition: 0.3s;" onmouseover="this.style.borderColor='#22c55e'; this.style.background='#f0fdf4';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='transparent';">
                    <i class="fas fa-plus-circle" style="font-size: 24px; color: #22c55e;"></i>
                    <span style="font-weight: 700; color: #475569;">Tambah Produk</span>
                </a>
                <a href="{{ url('admin/reports?type=monthly') }}" style="display: flex; flex-direction: column; gap: 10px; padding: 25px; border: 2px dashed #e2e8f0; border-radius: 20px; text-decoration: none; transition: 0.3s;" onmouseover="this.style.borderColor='#0ea5e9'; this.style.background='#f0f9ff';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='transparent';">
                    <i class="fas fa-calendar-check" style="font-size: 24px; color: #0ea5e9;"></i>
                    <span style="font-weight: 700; color: #475569;">Laporan Bulanan</span>
                </a>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #166534 0%, #15803d 100%); padding: 35px; border-radius: 28px; color: white; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
            <i class="fas fa-leaf" style="position: absolute; right: -30px; bottom: -30px; font-size: 180px; opacity: 0.15; transform: rotate(-20deg);"></i>
            <h4 style="margin: 0; font-size: 24px; font-weight: 800; line-height: 1.3;">Sistem Koperasi <br> Digital Mahasiswa</h4>
            <p style="margin: 15px 0 0; opacity: 0.9; font-size: 15px; line-height: 1.6;">
                Pantau perkembangan bisnis koperasi kamu secara real-time.
            </p>
        </div>
    </div>

</div>
@endsection