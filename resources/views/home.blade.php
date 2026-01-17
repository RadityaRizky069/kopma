@extends('layouts.main')

@section('title', 'KOPMA - Home')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@if(auth()->check() && auth()->user()->role == 'admin')
    {{-- ========================================== --}}
    {{-- TAMPILAN BERANDA KHUSUS ADMIN (DASHBOARD) --}}
    {{-- ========================================== --}}
    <div style="padding: 40px; background: #f8fafc; min-height: 90vh; font-family: 'Inter', sans-serif;">
        <div class="container">
            <div style="margin-bottom: 30px;">
                <h2 style="font-weight: 800; color: #1e293b;">Halo, Administrator 👋</h2>
                <p style="color: #64748b;">Panel ringkasan cepat untuk mengelola KOPMA hari ini.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
                <div style="background: white; padding: 25px; border-radius: 20px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 20px;">
                    <div style="background: #dcfce7; color: #166534; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <small style="color: #64748b; font-weight: 600;">Produk Aktif</small>
                        <h4 style="margin: 0; font-size: 24px; font-weight: 800;">{{ $products->count() }}</h4>
                    </div>
                </div>

                <div style="background: white; padding: 25px; border-radius: 20px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 20px;">
                    <div style="background: #e0f2fe; color: #0369a1; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <small style="color: #64748b; font-weight: 600;">Total Member</small>
                        <h4 style="margin: 0; font-size: 24px; font-weight: 800;">Aktif</h4>
                    </div>
                </div>
            </div>

            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #1e293b;">Akses Cepat Pengelolaan</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <a href="{{ route('admin.products.index') }}" style="text-decoration: none; background: white; padding: 30px; border-radius: 20px; border: 1px solid #e2e8f0; text-align: center; transition: 0.3s;" onmouseover="this.style.borderColor='#28a745'">
                    <i class="fas fa-edit" style="font-size: 30px; color: #28a745; margin-bottom: 15px;"></i>
                    <span style="display: block; font-weight: 700; color: #1e293b;">Kelola Produk</span>
                </a>
                <a href="{{ url('admin/reports') }}" style="text-decoration: none; background: white; padding: 30px; border-radius: 20px; border: 1px solid #e2e8f0; text-align: center; transition: 0.3s;" onmouseover="this.style.borderColor='#28a745'">
                    <i class="fas fa-file-invoice-dollar" style="font-size: 30px; color: #28a745; margin-bottom: 15px;"></i>
                    <span style="display: block; font-weight: 700; color: #1e293b;">Laporan Keuangan</span>
                </a>
                <a href="{{ url('admin/customers') }}" style="text-decoration: none; background: white; padding: 30px; border-radius: 20px; border: 1px solid #e2e8f0; text-align: center; transition: 0.3s;" onmouseover="this.style.borderColor='#28a745'">
                    <i class="fas fa-user-shield" style="font-size: 30px; color: #28a745; margin-bottom: 15px;"></i>
                    <span style="display: block; font-weight: 700; color: #1e293b;">Data Customer</span>
                </a>
            </div>
        </div>
    </div>

@else
    {{-- ========================================== --}}
    {{-- TAMPILAN BERANDA CUSTOMER / UMUM --}}
    {{-- ========================================== --}}
    <section class="container" style="margin-top:80px;">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:64px; align-items:center;">
            <div>
                <span style="background:#DCFCE7; color:#166534; padding:6px 14px; border-radius:999px; font-size:13px; font-weight:600;">
                    Platform Koperasi Digital
                </span>
                <h1 style="font-size:48px; font-weight:800; line-height:1.2; margin:20px 0;">
                    @auth Halo, {{ auth()->user()->name }}! @else Belanja di Koperasi <br>Jadi Lebih Mudah @endauth
                </h1>
                <p style="font-size:18px; color:#6B7280; max-width:520px; line-height:1.7;">
                    KOPMA menghadirkan pengalaman koperasi mahasiswa yang modern dan mudah diakses kapan saja.
                </p>
                <div style="margin-top:36px;">
                    <a href="{{ url('/products') }}" style="background:#28a745; border:none; padding:15px 35px; border-radius:12px; color:white; text-decoration:none; font-weight:700;">
                        @auth Belanja Sekarang @else Daftar Sekarang @endauth
                    </a>
                </div>
            </div>
            <div style="background:#F0FDF4; border-radius:32px; height:380px; display:flex; align-items:center; justify-content:center; color:#166534; font-weight:700;">
                Preview Aplikasi
            </div>
        </div>
    </section>

    <section class="container" style="margin-top:100px; padding-bottom: 50px;">
        <h2 style="font-size:28px; font-weight:700; margin-bottom:32px; color: #1f2937;">Produk Populer</h2>
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:30px;">
            @forelse($products as $p)
                <div style="background: white; border-radius: 20px; padding: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.03); border: 1px solid #f0f0f0;">
                    <div style="width: 100%; height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 15px; background: #f9fafb;">
                        @if($p->gambar)
                            <img src="{{ asset('storage/' . $p->gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af;">No Image</div>
                        @endif
                    </div>
                    <h3 style="font-size:18px; font-weight:700; color: #1f2937; margin: 0 0 10px 0;">{{ $p->nama_produk }}</h3>
                    <p style="font-size: 18px; font-weight: 800; color: #166534;">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                    <button style="width:100%; background:#28a745; color:white; border:none; padding:12px; border-radius:12px; font-weight:700; margin-top:10px;">+ Keranjang</button>
                </div>
            @empty
                <p>Belum ada produk.</p>
            @endforelse
        </div>
    </section>
@endif

@endsection