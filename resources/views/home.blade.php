@extends('layouts.main')

@section('title', 'Beranda')

@section('content')

{{-- CSS KHUSUS HALAMAN HOME (ANIMASI) --}}
<style>
    /* 1. Animasi Hero Section (Teks muncul dari kiri, Gambar dari kanan) */
    .hero-content { opacity: 0; animation: fadeSlideRight 1s ease forwards; }
    .hero-image { opacity: 0; animation: fadeSlideLeft 1s ease forwards; animation-delay: 0.2s; }

    /* 2. Animasi Produk (Muncul dari bawah satu per satu) */
    .product-card {
        opacity: 0; /* Awalnya tersembunyi */
        transform: translateY(40px); /* Awalnya agak ke bawah */
        animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    /* Keyframes Definisi Animasi */
    @keyframes fadeSlideRight {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeSlideLeft {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Hover Effect untuk Kartu */
    .product-card:hover {
        transform: translateY(-10px) !important; /* Naik sedikit saat di-hover */
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
</style>

<div class="container" style="padding-top: 60px; padding-bottom: 80px;">
    
    {{-- HERO SECTION --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; margin-bottom: 100px;">
        <div class="hero-content">
            <span style="background: #dcfce7; color: #15803d; padding: 8px 16px; border-radius: 99px; font-weight: 700; font-size: 13px; display: inline-block; margin-bottom: 20px;">
                <i class="fa-solid fa-check-circle"></i> Platform Koperasi Digital
            </span>
            <h1 style="font-size: 48px; font-weight: 800; line-height: 1.2; margin-bottom: 20px; color: #1e293b;">
                Belanja di Koperasi <br> Jadi Lebih Mudah
            </h1>
            <p style="color: #64748b; font-size: 18px; line-height: 1.6; margin-bottom: 30px; max-width: 480px;">
                KOPMA menghadirkan pengalaman belanja koperasi mahasiswa yang modern, transparan, dan dapat diakses kapan saja.
            </p>
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 16px 32px; font-size: 16px; box-shadow: 0 10px 20px rgba(21,128,61,0.2);">
                Daftar Anggota Sekarang
            </a>
        </div>
        
        <div class="hero-image" style="background: #f0fdf4; height: 400px; border-radius: 40px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #15803d; border: 2px dashed #bbf7d0;">
            <i class="fa-solid fa-mobile-screen" style="font-size: 64px; margin-bottom: 20px;"></i>
            <span style="font-weight: 700; font-size: 18px;">Preview Aplikasi</span>
        </div>
    </div>

    {{-- PRODUK POPULER SECTION --}}
    <div style="display: flex; justify-content: space-between; align-items: end; margin-bottom: 40px;">
        <div class="hero-content" style="animation-delay: 0.4s;"> {{-- Delay sedikit biar muncul setelah hero --}}
            <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 10px; color: #1e293b;">Produk Populer</h2>
            <p style="color: #64748b; margin: 0;">Pilihan terbaik untuk kebutuhan mahasiswa hari ini.</p>
        </div>
        <a href="{{ route('products.index') }}" style="color: #15803d; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: 0.3s;" onmouseover="this.style.gap='12px'" onmouseout="this.style.gap='8px'">
            Lihat Semua <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    {{-- GRID PRODUK (DENGAN ANIMASI) --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 30px;">
        @foreach($products as $product)
            <div class="card product-card" style="padding: 15px; border-radius: 20px; transition: 0.3s; animation-delay: {{ $loop->iteration * 100 }}ms;"> 
                {{-- ^^^ LOGIKA ANIMASI: Delay dikali urutan loop (100ms, 200ms, 300ms...) --}}
                
                {{-- Gambar Produk --}}
                <div style="height: 200px; background: #f1f5f9; border-radius: 16px; overflow: hidden; position: relative; margin-bottom: 15px;">
                    <img src="{{ $product->gambar ? asset('storage/' . $product->gambar) : 'https://via.placeholder.com/300' }}" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: 0.5s;"
                         onmouseover="this.style.transform='scale(1.1)'" 
                         onmouseout="this.style.transform='scale(1)'">
                    
                    {{-- Badge Stok --}}
                    <span style="position: absolute; top: 12px; left: 12px; background: rgba(255,255,255,0.9); backdrop-filter: blur(4px); padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; color: #1e293b; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        {{ $product->stok }} Stok
                    </span>
                </div>

                {{-- Detail Produk --}}
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #1e293b;">{{ $product->nama_produk }}</h3>
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #15803d; font-weight: 800; font-size: 16px;">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </span>
                    
                    {{-- Tombol Add to Cart (Icon) --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: #15803d; color: white; width: 36px; height: 36px; border-radius: 10px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s;" onmouseover="this.style.transform='scale(1.1) rotate(90deg)'" onmouseout="this.style.transform='scale(1) rotate(0deg)'" title="Tambah ke Keranjang">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

</div>

@endsection