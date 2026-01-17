@extends('layouts.main')

@section('title', 'KOPMA - Beranda')

@section('content')

<section class="container" style="margin-top:80px;">
    <div style="
        display:grid;
        grid-template-columns: 1.1fr .9fr;
        gap:64px;
        align-items:center;
    ">
        <div>
            <span style="
                background:#DCFCE7;
                color:#166534;
                padding:6px 14px;
                border-radius:999px;
                font-size:13px;
                font-weight:600;
            ">
                Platform Koperasi Digital
            </span>

            <h1 style="
                font-size:48px;
                font-weight:800;
                line-height:1.2;
                margin:20px 0;
            ">
                Belanja di Koperasi  
                <br>Jadi Lebih Mudah
            </h1>

            <p style="
                font-size:18px;
                color:#6B7280;
                max-width:520px;
                line-height:1.7;
            ">
                KOPMA menghadirkan pengalaman koperasi mahasiswa yang modern,
                cepat, transparan, dan mudah diakses kapan saja.
            </p>

            <div style="margin-top:36px;">
                <a href="{{ route('register') }}" class="btn btn-primary" style="background:#28a745; border:none; padding:12px 24px; border-radius:10px; color:white; text-decoration:none; font-weight:600;">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <div style="
            background:#F0FDF4;
            border-radius:32px;
            height:380px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
            font-weight:600;
            color:#166534;
            overflow:hidden;
        ">
            Preview Aplikasi
        </div>
    </div>
</section>

<section style="margin-top:80px;">
    <div class="container">
        <div style="
            display:flex;
            gap:12px;
            max-width:520px;
        ">
            <input type="text" placeholder="Cari produk..."
                style="
                    flex:1;
                    padding:14px;
                    border-radius:14px;
                    border:1px solid #E5E7EB;
                    font-size:14px;
                    outline:none;
                ">
            <button class="btn btn-primary" style="background:#28a745; border:none; padding:0 25px; border-radius:12px; color:white; font-weight:600; cursor:pointer;">
                Cari
            </button>
        </div>
    </div>
</section>

<section class="container" style="margin-top:120px; padding-bottom: 50px;">
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:32px;
    ">
        <h2 style="font-size:28px; font-weight:700; color: #1f2937;">
            Produk Populer
        </h2>
    </div>

    <div style="
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap:30px;
    ">
        @forelse($products as $p)
        <div class="card" style="background: white; border-radius: 20px; padding: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; transition: 0.3s;">
            
            <div style="width: 100%; height: 200px; border-radius: 15px; overflow: hidden; margin-bottom: 15px; background: #f9fafb;">
                @if($p->gambar)
                    <img src="{{ asset('storage/' . $p->gambar) }}" 
                         alt="{{ $p->nama_produk }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 14px;">
                        No Image
                    </div>
                @endif
            </div>

            <h3 style="font-size:18px; font-weight:700; color: #1f2937; margin: 0 0 5px 0;">
                {{ $p->nama_produk }}
            </h3>
            
            <p style="font-size: 13px; color: #6b7280; margin-bottom: 15px; line-height: 1.4; height: 36px; overflow: hidden;">
                {{ $p->deskripsi ?? 'Pilihan terbaik untuk kebutuhan mahasiswa.' }}
            </p>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <span style="font-size: 18px; font-weight: 800; color: #166534;">
                    Rp {{ number_format($p->harga, 0, ',', '.') }}
                </span>
                <span style="font-size: 12px; color: #9ca3af;">Stok: {{ $p->stok }}</span>
            </div>

            <button style="width:100%; background:#28a745; color:white; border:none; padding:12px; border-radius:12px; font-weight:700; cursor:pointer; transition: 0.3s;">
                + Keranjang
            </button>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 50px; color: #9ca3af;">
            <p>Belum ada produk yang ditambahkan oleh admin.</p>
        </div>
        @endforelse
    </div>
</section>

<section style="
    margin-top:120px;
    padding:80px 0;
    background: linear-gradient(135deg, #28a745, #166534);
    text-align:center;
    color:white;
">
    <h3 style="font-size:32px; font-weight:800; margin: 0;">
        Promo Mingguan 🎉
    </h3>
    <p style="margin-top:15px; font-size: 18px; opacity: 0.9;">
        Nikmati diskon spesial untuk mahasiswa koperasi!
    </p>
    <button style="margin-top: 30px; background: white; color: #166534; border: none; padding: 12px 30px; border-radius: 999px; font-weight: 700; cursor: pointer;">
        Cek Promo Sekarang
    </button>
</section>

@endsection