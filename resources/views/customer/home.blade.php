@extends('layouts.main')

@section('title', 'Belanja - KOPMA')

@section('content')

<section class="container" style="margin-top:40px;">
    <div style="
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
        align-items: center;
    ">
        <div>
            <h1 style="font-size:28px; font-weight:800; margin-bottom:12px;">
                Halo, {{ Auth::user()->name ?? 'Anggota KOPMA' }}! 👋
            </h1>
            <p style="color:#6B7280; margin-bottom:24px;">
                Mau cari jajan atau kebutuhan apa hari ini?
            </p>

            <form action="" style="display:flex; gap:12px;">
                <input type="text" placeholder="Cari barang (ex: Air Mineral)..." 
                    style="
                        flex:1; 
                        padding:14px 20px; 
                        border-radius:14px; 
                        border:1px solid #E5E7EB; 
                        background:#F9FAFB;
                        outline:none;
                        font-size:14px;
                    ">
                <button class="btn btn-primary">Cari</button>
            </form>
        </div>

        <div class="card" style="
            background: linear-gradient(135deg, #15803D, #166534);
            color: white;
            border: none;
            box-shadow: 0 20px 40px rgba(21, 128, 61, 0.2);
        ">
            <div style="font-size:13px; opacity:0.9; margin-bottom:8px;">Saldo Simpanan</div>
            <div style="font-size:32px; font-weight:800; margin-bottom:20px;">
                Rp 150.000
            </div>
            <div style="display:flex; gap:12px;">
                <button style="
                    background: rgba(255,255,255,0.2);
                    color: white;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 8px;
                    font-size:12px;
                    font-weight:600;
                    cursor:pointer;
                ">
                    + Topup
                </button>
                <button style="
                    background: white;
                    color: #15803D;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 8px;
                    font-size:12px;
                    font-weight:600;
                    cursor:pointer;
                ">
                    Riwayat
                </button>
            </div>
        </div>
    </div>
</section>

<section class="container" style="margin-top:60px;">
    <h3 style="font-size:20px; font-weight:700; margin-bottom:24px;">Kategori</h3>
    
    <div style="display:flex; gap:24px; overflow-x:auto; padding-bottom:10px;">
        @foreach(['Makanan', 'Minuman', 'ATK', 'Merchandise', 'Jasa'] as $cat)
        <a href="#" style="
            display:flex; 
            flex-direction:column; 
            align-items:center; 
            gap:10px; 
            min-width:80px;
        ">
            <div style="
                width:60px; 
                height:60px; 
                background: white; 
                border-radius: 16px; 
                border: 1px solid #E5E7EB;
                display:flex; 
                align-items:center; 
                justify-content:center;
                font-size:24px;
                transition: .2s;
            " onmouseover="this.style.borderColor='#15803D'; this.style.color='#15803D'" 
              onmouseout="this.style.borderColor='#E5E7EB'; this.style.color='inherit'">
                📦
            </div>
            <span style="font-size:13px; font-weight:600; color:#4B5563;">{{ $cat }}</span>
        </a>
        @endforeach
    </div>
</section>

<section class="container" style="margin-top:50px; margin-bottom:100px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h3 style="font-size:20px; font-weight:700;">Rekomendasi Hari Ini</h3>
        <a href="#" style="font-size:14px; font-weight:600; color:#15803D;">Lihat Semua &rarr;</a>
    </div>

    <div style="
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap:24px;
    ">
        @for($i = 1; $i <= 8; $i++)
        <div class="card" style="padding:16px;">
            <div style="position:relative;">
                <img src="https://via.placeholder.com/300x300" 
                     style="width:100%; border-radius:12px; aspect-ratio: 1/1; object-fit:cover; margin-bottom:12px;">
                
                <span style="
                    position:absolute; top:8px; left:8px; 
                    background:rgba(0,0,0,0.6); color:white; 
                    padding:4px 8px; border-radius:6px; font-size:10px; font-weight:600;
                ">
                    Stok: 12
                </span>
            </div>

            <h4 style="font-size:16px; font-weight:700; margin:0 0 4px 0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                Roti Bakar Premium
            </h4>
            <p style="font-size:12px; color:#6B7280; margin:0 0 12px 0;">Makanan Ringan</p>

            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:16px; font-weight:800; color:#15803D;">Rp 12.000</span>
                <button style="
                    width:32px; height:32px; 
                    border-radius:8px; 
                    background:#DCFCE7; 
                    color:#15803D; 
                    border:none; 
                    display:flex; align-items:center; justify-content:center;
                    cursor:pointer;
                ">+</button>
            </div>
        </div>
        @endfor
    </div>
</section>

@endsection