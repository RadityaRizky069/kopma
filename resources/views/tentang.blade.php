@extends('layouts.main') 

@section('title', 'Tentang Kami - KOPMA')

@section('content')

{{-- CSS KHUSUS HALAMAN INI --}}
<style>
    /* Hero Section */
    .about-hero {
        padding: 80px 0;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        overflow: hidden;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 0.9fr;
        gap: 60px;
        align-items: center;
    }

    .hero-content h1 {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 20px;
        color: var(--text);
        line-height: 1.2;
    }

    .hero-content p {
        font-size: 18px;
        color: var(--muted);
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .hero-image {
        position: relative;
    }

    .hero-image img {
        width: 100%;
        border-radius: var(--radius);
        box-shadow: 0 30px 60px rgba(0,0,0,0.1);
        transition: transform 0.5s ease;
    }

    .hero-image:hover img {
        transform: scale(1.02);
    }

    /* Values / Fitur Section */
    .values-section {
        padding: 100px 0;
    }

    .section-title {
        text-align: center;
        max-width: 600px;
        margin: 0 auto 60px auto;
    }

    .section-title h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 16px;
    }

    .section-title p {
        color: var(--muted);
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .value-card {
        text-align: center;
        height: 100%;
        padding: 40px 30px;
    }

    .icon-box {
        width: 70px;
        height: 70px;
        background: var(--primary-soft);
        color: var(--primary);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin: 0 auto 24px auto;
    }

    .value-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .value-card p {
        font-size: 15px;
        color: var(--muted);
        line-height: 1.6;
    }

    /* Quote Section */
    .quote-section {
        background: var(--bg);
        padding: 80px 0;
        text-align: center;
        border-top: 1px solid var(--border);
    }
    
    .quote-box {
        max-width: 800px;
        margin: auto;
    }
    
    .quote-text {
        font-size: 24px;
        font-style: italic;
        font-weight: 500;
        color: var(--text);
        margin-bottom: 24px;
    }

    /* Responsive HP */
    @media (max-width: 768px) {
        .hero-grid {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 40px;
        }
        .hero-image {
            order: -1;
        }
        .hero-content h1 {
            font-size: 32px;
        }
        .hero-content div {
            justify-content: center !important; /* Paksa tombol ke tengah di HP */
        }
    }
</style>

{{-- SECTION 1: HERO --}}
<section class="about-hero">
    <div class="container">
        <div class="hero-grid">
            
            <div class="hero-content">
                <span style="color: var(--primary); font-weight: 700; letter-spacing: 1px; font-size: 14px; text-transform: uppercase; display: block; margin-bottom: 12px;">Tentang Kami</span>
                <h1>Membangun Ekonomi Mahasiswa Bersama KOPMA</h1>
                <p>
                    Koperasi Mahasiswa bukan sekadar tempat belanja. Ini adalah wadah kolaborasi, inovasi, dan kewirausahaan untuk masa depan yang lebih mandiri.
                </p>
                
                {{-- LOGIC TOMBOL BERBEDA SESUAI ROLE --}}
                <div style="display: flex; gap: 16px; justify-content: flex-start;">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            {{-- Kalau ADMIN --}}
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                                Kelola Produk
                            </a>
                        @else
                            {{-- Kalau CUSTOMER --}}
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                Lihat Produk
                            </a>
                        @endif
                    @else
                        {{-- Kalau BELUM LOGIN --}}
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Gabung Anggota
                        </a>
                    @endauth
                </div>

            </div>

            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tim Kopma">
            </div>

        </div>
    </div>
</section>

{{-- SECTION 2: VALUES --}}
<section class="values-section">
    <div class="container">
        
        <div class="section-title">
            <h2>Kenapa KOPMA?</h2>
            <p>Kami berdedikasi memberikan layanan terbaik dengan harga mahasiswa, dari mahasiswa, untuk mahasiswa.</p>
        </div>

        <div class="values-grid">
            <div class="card value-card">
                <div class="icon-box">🏷️</div>
                <h3>Harga Mahasiswa</h3>
                <p>Kami paham kebutuhanmu. Dapatkan produk berkualitas dengan harga yang sangat bersahabat di kantong.</p>
            </div>

            <div class="card value-card">
                <div class="icon-box">🚀</div>
                <h3>Layanan Cepat</h3>
                <p>Sistem pemesanan modern yang terintegrasi memastikan pesananmu diproses tanpa ribet.</p>
            </div>

            <div class="card value-card">
                <div class="icon-box">🤝</div>
                <h3>Dari Kita Untuk Kita</h3>
                <p>Setiap transaksi yang kamu lakukan membantu memajukan ekonomi komunitas mahasiswa kampus kita.</p>
            </div>
        </div>

    </div>
</section>

{{-- SECTION 3: QUOTE --}}
<section class="quote-section">
    <div class="container">
        <div class="quote-box">
            <p class="quote-text">"Koperasi adalah soko guru perekonomian Indonesia, dan mahasiswa adalah agen perubahannya."</p>
            <div style="font-weight: 700; color: var(--primary);">Radit Femboy</div>
            <div style="font-weight: 700; color: var(--primary);">Ketua KOPMA</div>
        </div>
    </div>
</section>

@endsection