@extends('layouts.main')

@section('title', 'Katalog Produk - KOPMA')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .product-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover .cart-btn {
        transform: translateY(0);
        opacity: 1;
    }
    .cart-btn {
        transform: translateY(10px);
        opacity: 0;
        transition: all 0.3s ease;
    }
</style>

<div style="background: #fdfdfd; min-height: 100vh; padding-top: 40px; padding-bottom: 80px;">
    <div class="container" style="max-width: 1200px; margin: auto; padding: 0 20px;">
        
        <div style="text-align: center; margin-bottom: 50px;" class="animate__animated animate__fadeIn">
            <h1 style="font-weight: 800; color: #1e293b; font-size: 32px; margin-bottom: 10px;">Katalog Produk Kami</h1>
            <p style="color: #64748b; font-size: 16px;">Pilih produk favoritmu dan tambahkan ke keranjang belanja!</p>
            <div style="width: 50px; height: 3px; background: #28a745; margin: 15px auto; border-radius: 2px;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 25px;">
            @forelse($products as $p)
            <div class="product-card animate__animated animate__fadeInUp" 
                 style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px rgba(0,0,0,0.02); position: relative;">
                
                <div style="position: absolute; top: 12px; left: 12px; background: rgba(255,255,255,0.9); backdrop-filter: blur(5px); color: #1e293b; padding: 4px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; z-index: 5; border: 1px solid #edf2f7;">
                    {{ $p->stok }} Stok
                </div>

                <div class="cart-btn" style="position: absolute; bottom: 110px; right: 15px; z-index: 10;">
                    <button onclick="Swal.fire({icon: 'success', title: 'Ditambahkan!', text: '{{ $p->nama_produk }} masuk keranjang', showConfirmButton: false, timer: 1500})"
                            style="background: #28a745; color: white; border: none; width: 45px; height: 45px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 10px 15px rgba(40,167,69,0.3); transition: 0.2s;"
                            onmouseover="this.style.transform='scale(1.1)';" 
                            onmouseout="this.style.transform='scale(1)';">
                        <i class="fas fa-shopping-basket"></i>
                    </button>
                </div>

                <div style="width: 100%; height: 250px; background: #f8fafc; overflow: hidden; position: relative;">
                    @if($p->gambar)
                        <img src="{{ asset('storage/' . $p->gambar) }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #cbd5e1;">
                            <i class="fas fa-box-open" style="font-size: 40px;"></i>
                        </div>
                    @endif
                </div>

                <div style="padding: 18px;">
                    <span style="color: #28a745; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $p->category->nama_kategori ?? 'Umum' }}
                    </span>
                    <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 5px 0 12px 0; min-height: 40px; line-height: 1.4;">
                        {{ $p->nama_produk }}
                    </h3>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8; font-weight: 600;">Harga</p>
                            <span style="font-size: 18px; font-weight: 800; color: #0f172a;">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection