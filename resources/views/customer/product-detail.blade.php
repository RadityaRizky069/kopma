@extends('layouts.main')

@section('content')
{{-- Load Font, Icons, & Animate.css --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* --- GLOBAL VARIABLES --- */
    :root {
        --primary: #10b981; 
        --primary-dark: #059669;
        --text-dark: #0f172a;
        --text-gray: #64748b;
        --bg-soft: #f8fafc;
        --border: #e2e8f0;
    }

    body {
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
        background-color: #ffffff;
    }

    .container-custom {
        max-width: 960px;
        margin: 0 auto;
        padding: 40px 20px 80px;
    }

    /* --- HEADER (TOMBOL KEMBALI) --- */
    .header-nav {
        margin-bottom: 30px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-gray);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: 0.3s;
        padding: 8px 16px;
        border-radius: 50px;
        background: white;
        border: 1px solid transparent;
    }

    .btn-back:hover {
        color: var(--primary);
        background: var(--bg-soft);
        border-color: var(--border);
        transform: translateX(-3px);
    }

    /* --- PRODUCT CARD (BAGIAN ATAS) --- */
    .product-main-card {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border);
        overflow: hidden;
        display: flex;
        flex-wrap: wrap;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        margin-bottom: 60px;
    }

    .product-img-col {
        flex: 1;
        min-width: 320px;
        background: var(--bg-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .product-img-col img {
        width: 100%;
        max-width: 320px;
        height: auto;
        object-fit: contain;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.08));
        transition: transform 0.3s;
    }

    .product-img-col img:hover { transform: scale(1.05); }

    .product-info-col {
        flex: 1.3;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .badge-label {
        background: #dcfce7;
        color: var(--primary-dark);
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 6px 12px;
        border-radius: 8px;
        width: fit-content;
        margin-bottom: 15px;
        letter-spacing: 0.5px;
    }

    .product-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.1;
        letter-spacing: -0.5px;
    }

    .product-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 25px;
    }

    .product-desc {
        color: var(--text-gray);
        line-height: 1.7;
        font-size: 1rem;
        margin-bottom: 30px;
    }

    .btn-add-cart {
        background: var(--primary);
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-add-cart:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    /* --- BAGIAN KOMENTAR --- */
    .comments-section {
        max-width: 800px;
        margin: 0 auto;
    }

    .section-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
    }

    .section-head h3 {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
    }

    .count-pill {
        background: var(--text-dark);
        color: white;
        font-size: 0.75rem;
        padding: 2px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    /* Input Komentar */
    .comment-form-wrapper {
        display: flex;
        gap: 20px;
        margin-bottom: 50px;
    }

    .user-avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #a7f3d0, #34d399);
        color: #064e3b;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    
    .user-avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .comment-box {
        flex-grow: 1;
        position: relative;
    }

    .comment-textarea {
        width: 100%;
        border: 1px solid var(--border);
        background: #fdfdfd;
        border-radius: 16px;
        padding: 15px;
        min-height: 100px;
        resize: none;
        font-family: inherit;
        transition: 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .comment-textarea:focus {
        outline: none;
        background: white;
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .btn-post-comment {
        margin-top: 10px;
        background: var(--text-dark);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.2s;
        float: right;
    }

    .btn-post-comment:hover {
        background: black;
    }

    /* List Komentar */
    .comment-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .comment-card {
        background: white;
        border-radius: 16px;
        padding: 15px;
        display: flex;
        gap: 16px;
        /* Tambahan efek hover */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid transparent;
    }

    .comment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        border-color: #f1f5f9;
    }

    /* Link Avatar & User */
    .avatar-link {
        text-decoration: none;
        transition: transform 0.2s;
        display: block;
    }
    .avatar-link:hover { transform: scale(1.1); }

    .comment-avatar {
        width: 42px;
        height: 42px;
        background: #f1f5f9;
        color: var(--text-gray);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
        overflow: hidden;
    }
    
    .comment-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .comment-content { flex: 1; }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 6px;
    }

    .comment-user-link {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .comment-user-link:hover { color: var(--primary); }
    .comment-user-link:hover .comment-user-name {
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .comment-time {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .comment-text {
        color: #475569;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .comment-actions {
        display: flex;
        gap: 15px;
    }

    .action-link {
        background: none;
        border: none;
        padding: 0;
        color: #94a3b8;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: 0.2s;
    }

    .action-link:hover { color: var(--primary); }
    .action-link.active { color: var(--primary); }
    .action-link.delete:hover { color: #ef4444; }

    /* Responsif */
    @media (max-width: 768px) {
        .product-img-col { min-height: 250px; padding: 20px; }
        .product-info-col { padding: 30px 20px; }
        .product-title { font-size: 1.8rem; }
    }
</style>

<div class="container-custom">
    
    <!-- 1. HEADER DENGAN ANIMASI TURUN -->
    <div class="header-nav animate__animated animate__fadeInDown">
        <a href="{{ route('products.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- 2. DETAIL PRODUK DENGAN ANIMASI NAIK -->
    <div class="product-main-card animate__animated animate__fadeInUp">
        <div class="product-img-col">
            @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}">
            @else
                <div style="text-align: center; color: #cbd5e1;">
                    <i class="bi bi-image" style="font-size: 4rem;"></i>
                    <p>No Image</p>
                </div>
            @endif
        </div>
        <div class="product-info-col">
            <div>
                <span class="badge-label">Official Store</span>
                <h1 class="product-title">{{ $product->nama_produk }}</h1>
                <div class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                <p class="product-desc">{{ $product->deskripsi }}</p>
            </div>

            @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-add-cart">
                        <i class="bi bi-bag-plus"></i> Masukkan Keranjang
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <!-- 3. BAGIAN KOMENTAR -->
    <div class="comments-section animate__animated animate__fadeIn animate__delay-1s">
        
        <div class="section-head">
            <h3>Ulasan Pembeli</h3>
            <span class="count-pill">{{ $product->comments->count() }}</span>
        </div>

        <!-- Form Input -->
        @auth
        <div class="comment-form-wrapper">
            <div class="user-avatar-circle">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="comment-box">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <textarea name="content" class="comment-textarea" placeholder="Tulis pendapatmu tentang produk ini..." required></textarea>
                    <button class="btn-post-comment">Kirim Ulasan</button>
                </form>
            </div>
        </div>
        @else
        <div class="alert alert-light text-center border mb-5" style="border-radius: 12px;">
            <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">Login</a> untuk memberikan ulasan.
        </div>
        @endauth

        <!-- Daftar Komentar (ANIMASI CASCADE) -->
        <div class="comment-list">
            @forelse($product->comments as $comment)
            {{-- Loop variable $loop->index digunakan untuk delay animasi per item --}}
            <div class="comment-card animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s; animation-fill-mode: both;">
                
                {{-- AVATAR LINK --}}
                <a href="{{ url('/profile/' . $comment->user->id) }}" class="avatar-link" title="Lihat Profil">
                    <div class="comment-avatar">
                        @if($comment->user->avatar)
                            <img src="{{ asset('storage/' . $comment->user->avatar) }}">
                        @else
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        @endif
                    </div>
                </a>

                <div class="comment-content">
                    <div class="comment-header">
                        {{-- NAMA USER LINK --}}
                        <a href="{{ url('/profile/' . $comment->user->id) }}" class="comment-user-link" title="Kunjungi Profil {{ $comment->user->name }}">
                            <span class="comment-user-name">{{ $comment->user->name }}</span>
                            @if($comment->user->role === 'admin') 
                                <i class="bi bi-patch-check-fill text-primary" style="font-size: 0.8rem;" title="Admin Terverifikasi"></i>
                            @endif
                        </a>

                        <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="comment-text">
                        {{ $comment->content }}
                    </div>

                    <div class="comment-actions">
                        <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="action-link {{ $comment->likes > 0 ? 'active' : '' }}">
                                <i class="bi bi-hand-thumbs-up{{ $comment->likes > 0 ? '-fill' : '' }}"></i>
                                <span>{{ $comment->likes > 0 ? $comment->likes : 'Suka' }}</span>
                            </button>
                        </form>

                        @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="action-link delete" onclick="return confirm('Hapus komentar?')">Hapus</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5" style="color: #94a3b8;">
                <i class="bi bi-chat-quote" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                <p>Belum ada ulasan. Jadilah yang pertama berkomentar!</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection