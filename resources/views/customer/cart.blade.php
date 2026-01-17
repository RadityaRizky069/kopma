@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')

<style>
    .cart-section {
        padding: 60px 0;
        min-height: 80vh;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1e293b;
    }

    /* Layout Grid: Kiri (Barang) - Kanan (Ringkasan) */
    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 40px;
    }

    /* ITEM LIST */
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 20px;
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .item-img {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f1f1;
        border: 1px solid #f1f5f9;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 5px;
        display: block;
        color: #1e293b;
    }

    .item-price {
        color: #64748b;
        font-weight: 500;
        font-size: 14px;
    }

    .item-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        text-align: right;
    }

    .qty-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
    }

    .subtotal-text {
        color: #28a745;
        font-weight: 700;
        font-size: 16px;
    }

    /* SUMMARY CARD (KANAN) */
    .cart-summary {
        background: white;
        padding: 30px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        height: fit-content;
        position: sticky;
        top: 100px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
        color: #64748b;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px dashed #e2e8f0;
        font-weight: 800;
        font-size: 18px;
        color: #1e293b;
    }

    .btn-checkout {
        background: #28a745;
        color: white;
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        font-weight: 700;
        margin-top: 25px;
        text-align: center;
        border: none;
        cursor: pointer;
        transition: 0.2s;
        box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);
    }
    
    .btn-checkout:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-cart {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
        border: 2px dashed #e2e8f0;
    }

    @media (max-width: 768px) {
        .cart-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="cart-section">
    <div class="container" style="max-width: 1200px; margin: auto; padding: 0 20px;">
        
        <h1 class="page-title">🛒 Keranjang Belanja</h1>

        {{-- Cek apakah keranjang kosong --}}
        @if($cartItems->isEmpty())
            <div class="empty-cart animate__animated animate__fadeIn">
                <i class="fas fa-shopping-cart" style="font-size: 60px; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h3 style="color: #1e293b; margin-bottom: 10px;">Keranjang masih kosong</h3>
                <p style="color: #64748b; margin-bottom: 25px;">Yuk mulai belanja dan penuhi kebutuhanmu!</p>
                <a href="{{ route('products.index') }}" class="btn-checkout" style="text-decoration: none; display: inline-block; width: auto; padding: 12px 30px;">
                    Mulai Belanja
                </a>
            </div>
        @else
            
            <div class="cart-grid">
                
                {{-- DAFTAR BARANG (KIRI) --}}
                <div class="cart-items animate__animated animate__fadeInLeft">
                    @php $grandTotal = 0; @endphp

                    @foreach($cartItems as $item)
                        {{-- Hitung Subtotal per item --}}
                        @php 
                            // Pastikan data produk ada (mencegah error jika produk dihapus admin)
                            if($item->product) {
                                $harga = $item->product->harga;
                                $subtotal = $harga * $item->jumlah; 
                                $grandTotal += $subtotal;
                            } else {
                                $harga = 0;
                                $subtotal = 0;
                            }
                        @endphp

                        @if($item->product)
                        <div class="cart-item">
                            {{-- Gambar Produk --}}
                            <div class="item-img-wrapper">
                                @if($item->product->gambar)
                                    <img src="{{ asset('storage/' . $item->product->gambar) }}" class="item-img" alt="Produk">
                                @else
                                    <div class="item-img" style="display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                                        <i class="fas fa-box"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="item-details">
                                <span class="item-name">{{ $item->product->nama_produk }}</span>
                                <span class="item-price">@ Rp {{ number_format($harga, 0, ',', '.') }}</span>
                            </div>

                            <div class="item-actions">
                                <span class="qty-badge">{{ $item->jumlah }} pcs</span>
                                <span class="subtotal-text">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                {{-- RINGKASAN PEMBAYARAN (KANAN) --}}
                <div class="cart-summary animate__animated animate__fadeInRight">
                    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 0;">Ringkasan</h3>
                    <div style="height: 1px; background: #e2e8f0; margin: 20px 0;"></div>

                    <div class="summary-row">
                        <span>Total Item</span>
                        <span style="font-weight: 600; color: #1e293b;">{{ $cartItems->sum('jumlah') }} Pcs</span>
                    </div>

                    <div class="summary-total">
                        <span>Total Tagihan</span>
                        <span style="color: #28a745;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>

                    {{-- Form Checkout --}}
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-checkout">
                            Checkout Sekarang <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                        </button>
                    </form>
                </div>

            </div>

        @endif

    </div>
</section>

@endsection