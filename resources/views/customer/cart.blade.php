@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')

<style>
    .cart-section {
        padding: 60px 0;
        min-height: 80vh; /* Biar footer gak naik */
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
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
        border-radius: var(--radius);
        border: 1px solid var(--border);
    }

    .item-img {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f1f1;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 5px;
        display: block;
    }

    .item-price {
        color: var(--primary);
        font-weight: 600;
    }

    .item-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .qty-badge {
        background: var(--bg);
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid var(--border);
    }

    /* SUMMARY CARD (KANAN) */
    .cart-summary {
        background: white;
        padding: 30px;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        height: fit-content;
        position: sticky;
        top: 100px; /* Biar ngikut pas scroll */
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
        color: var(--muted);
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px dashed var(--border);
        font-weight: 800;
        font-size: 18px;
        color: var(--text);
    }

    .btn-checkout {
        background: var(--primary);
        color: white;
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        font-weight: 700;
        margin-top: 20px;
        text-align: center;
        display: block;
    }
    
    .btn-checkout:hover {
        opacity: 0.9;
    }

    /* Empty State */
    .empty-cart {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: var(--radius);
        border: 1px dashed var(--border);
    }

    @media (max-width: 768px) {
        .cart-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="cart-section">
    <div class="container">
        
        <h1 class="page-title">🛒 Keranjang Belanja</h1>

        {{-- Cek apakah keranjang kosong --}}
        @if($cartItems->isEmpty())
            <div class="empty-cart">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="100" style="opacity: 0.5; margin-bottom: 20px;">
                <h3>Keranjang masih kosong</h3>
                <p style="color: var(--muted);">Yuk mulai belanja dan penuhi kebutuhanmu!</p>
                <br>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Mulai Belanja</a>
            </div>
        @else
            
            <div class="cart-grid">
                
                {{-- DAFTAR BARANG (KIRI) --}}
                <div class="cart-items">
                    @php $grandTotal = 0; @endphp

                    @foreach($cartItems as $item)
                        {{-- Hitung Subtotal per item --}}
                        @php 
                            // Pastikan relasi product diload
                            $subtotal = $item->product->price * $item->jumlah; 
                            $grandTotal += $subtotal;
                        @endphp

                        <div class="cart-item">
                            {{-- Gambar Produk (Placeholder jika tidak ada gambar) --}}
                            <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/150' }}" class="item-img" alt="Produk">
                            
                            <div class="item-details">
                                <span class="item-name">{{ $item->product->name }}</span>
                                <span class="item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                            </div>

                            <div class="item-actions">
                                <span class="qty-badge">x {{ $item->jumlah }}</span>
                                <span style="font-weight: 700;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- RINGKASAN PEMBAYARAN (KANAN) --}}
                <div class="cart-summary">
                    <h3>Ringkasan</h3>
                    <div style="height: 1px; background: var(--border); margin: 20px 0;"></div>

                    <div class="summary-row">
                        <span>Total Item</span>
                        <span>{{ $cartItems->sum('jumlah') }} Pcs</span>
                    </div>

                    <div class="summary-total">
                        <span>Total Harga</span>
                        <span style="color: var(--primary);">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>

                    {{-- Form Checkout --}}
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-checkout">
                            Checkout Sekarang
                        </button>
                    </form>
                </div>

            </div>

        @endif

    </div>
</section>

@endsection