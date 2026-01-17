@extends('layouts.main')

@section('title', 'KOPMA - Home')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@if(auth()->check() && auth()->user()->role == 'admin')
    {{-- =========================================================== --}}
    {{-- TAMPILAN BERANDA KHUSUS ADMIN (DASHBOARD RINGKAS)         --}}
    {{-- =========================================================== --}}
    <div style="padding: 60px 20px; background: #f8fafc; min-height: 90vh; font-family: 'Inter', sans-serif;">
        <div class="container" style="max-width: 1100px; margin: auto;">
            
            <div style="margin-bottom: 40px;">
                <h1 style="font-weight: 800; color: #1e293b; font-size: 32px;">Halo, Administrator 👋</h1>
                <p style="color: #64748b; font-size: 18px;">Selamat datang di panel kendali KOPMA. Kelola data hari ini dengan cepat.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 50px;">
                <div style="background: white; padding: 30px; border-radius: 24px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
                    <div style="background: #dcfce7; color: #166534; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">Produk Aktif</small>
                        <h4 style="margin: 0; font-size: 28px; font-weight: 800; color: #1e293b;">{{ $products->count() }}</h4>
                    </div>
                </div>

                <div style="background: white; padding: 30px; border-radius: 24px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
                    <div style="background: #e0f2fe; color: #0369a1; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <small style="color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">Total Member</small>
                        <h4 style="margin: 0; font-size: 28px; font-weight: 800; color: #1e293b;">Aktif</h4>
                    </div>
                </div>
            </div>

            <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 25px; color: #1e293b; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-bolt" style="color: #f59e0b;"></i> Akses Cepat Pengelolaan
            </h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <a href="{{ route('admin.products.index') }}" style="text-decoration: none; background: white; padding: 35px 20px; border-radius: 24px; border: 1px solid #e2e8f0; text-align: center; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02);" onmouseover="this.style.borderColor='#28a745'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)'">
                    <i class="fas fa-edit" style="font-size: 40px; color: #28a745; margin-bottom: 20px; display: block;"></i>
                    <span style="display: block; font-weight: 800; color: #1e293b; font-size: 18px;">Kelola Produk</span>
                </a>

                <a href="{{ url('admin/reports') }}" style="text-decoration: none; background: white; padding: 35px 20px; border-radius: 24px; border: 1px solid #e2e8f0; text-align: center; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02);" onmouseover="this.style.borderColor='#28a745'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)'">
                    <i class="fas fa-file-invoice-dollar" style="font-size: 40px; color: #28a745; margin-bottom: 20px; display: block;"></i>
                    <span style="display: block; font-weight: 800; color: #1e293b; font-size: 18px;">Laporan Keuangan</span>
                </a>

                <a href="{{ url('admin/customers') }}" style="text-decoration: none; background: white; padding: 35px 20px; border-radius: 24px; border: 1px solid #e2e8f0; text-align: center; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02);" onmouseover="this.style.borderColor='#28a745'; this.style.transform='translateY(-5px)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)'">
                    <i class="fas fa-user-shield" style="font-size: 40px; color: #28a745; margin-bottom: 20px; display: block;"></i>
                    <span style="display: block; font-weight: 800; color: #1e293b; font-size: 18px;">Data Customer</span>
                </a>
            </div>
        </div>
    </div>

@else
    {{-- =========================================================== --}}
    {{-- TAMPILAN BERANDA CUSTOMER / UMUM (LANDING PAGE)          --}}
    {{-- =========================================================== --}}
    
    <section class="container" style="margin-top:80px; padding: 0 20px;">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:64px; align-items:center;">
            <div>
                <span style="background:#DCFCE7; color:#166534; padding:8px 18px; border-radius:999px; font-size:14px; font-weight:700; letter-spacing: 0.5px;">
                    <i class="fas fa-check-circle"></i> Platform Koperasi Digital
                </span>
                
                <h1 style="font-size:54px; font-weight:800; line-height:1.1; margin:25px 0; color: #1e293b; letter-spacing: -1.5px;">
                    @auth Halo, {{ auth()->user()->name }}! 👋 @else Belanja di Koperasi <br>Jadi Lebih Mudah @endauth
                </h1>
                
                <p style="font-size:19px; color:#64748b; max-width:520px; line-height:1.7; margin-bottom: 40px;">
                    KOPMA menghadirkan pengalaman belanja koperasi mahasiswa yang modern, transparan, dan dapat diakses kapan saja.
                </p>
                
                <div>
                    <a href="{{ url('/products') }}" style="background:#28a745; border:none; padding:18px 40px; border-radius:14px; color:white; text-decoration:none; font-weight:700; font-size: 16px; box-shadow: 0 10px 20px rgba(40,167,69,0.2); transition: 0.3s;">
                        @auth Mulai Belanja Sekarang @else Daftar Anggota Sekarang @endauth
                    </a>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius:40px; height:420px; display:flex; align-items:center; justify-content:center; color:#166534; font-weight:800; border: 2px dashed #bbf7d0; font-size: 20px;">
                <div style="text-align: center;">
                    <i class="fas fa-mobile-alt" style="font-size: 60px; margin-bottom: 15px; display: block;"></i>
                    Preview Aplikasi
                </div>
            </div>
        </div>
    </section>

    <section class="container" style="margin-top:120px; padding: 0 20px 80px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
            <div>
                <h2 style="font-size:32px; font-weight:800; color: #1e293b; letter-spacing: -0.5px;">Produk Populer</h2>
                <p style="color: #64748b; margin: 5px 0 0 0;">Pilihan terbaik untuk kebutuhan mahasiswa hari ini.</p>
            </div>
            <a href="/products" style="color: #28a745; font-weight: 700; text-decoration: none;">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap:30px;">
            @forelse($products as $p)
                <div style="background: white; border-radius: 24px; padding: 18px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; transition: 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 100%; height: 220px; border-radius: 18px; overflow: hidden; margin-bottom: 20px; background: #f8fafc; position: relative;">
                        <span style="position: absolute; top: 12px; left: 12px; background: white; padding: 5px 12px; border-radius: 10px; font-size: 11px; font-weight: 800; color: #64748b; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                            {{ $p->stok ?? '0' }} Stok
                        </span>
                        
                        @if($p->gambar)
                            <img src="{{ asset('storage/' . $p->gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #94a3b8; font-weight: 600;">No Image</div>
                        @endif
                    </div>

                    <small style="color: #28a745; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">Kategori Umum</small>
                    <h3 style="font-size:20px; font-weight:700; color: #1e293b; margin: 8px 0 15px 0; min-height: 24px;">{{ $p->nama_produk }}</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <span style="font-size: 22px; font-weight: 800; color: #1e293b;">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                    </div>

                    <button style="width:100%; background:#28a745; color:white; border:none; padding:15px; border-radius:14px; font-weight:700; cursor:pointer; display: flex; align-items:center; justify-content: center; gap: 10px; transition: 0.3s; font-size: 15px;" 
                            onmouseover="this.style.background='#218838'" 
                            onmouseout="this.style.background='#28a745'">
                        <i class="fas fa-cart-plus"></i> + Keranjang
                    </button>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: #f8fafc; border-radius: 20px;">
                    <i class="fas fa-box-open" style="font-size: 40px; color: #cbd5e1; margin-bottom: 15px; display: block;"></i>
                    <p style="color: #64748b; font-weight: 600;">Belum ada produk populer yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>
@endif

@endsection