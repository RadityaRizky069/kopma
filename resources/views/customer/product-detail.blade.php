@extends('layouts.main')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-green: #10b981; 
        --dark-green: #065f46;
        --soft-green: #ecfdf5;
        --border-color: #f1f5f9;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #ffffff;
        color: var(--text-main);
    }

    .product-info-card {
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
        background: #fff;
        margin-bottom: 40px;
    }

    .price-badge {
        display: inline-block;
        padding: 6px 16px;
        background-color: var(--soft-green);
        color: var(--primary-green);
        border-radius: 99px;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .section-title {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comment-input-container {
        display: flex;
        gap: 16px;
        margin-bottom: 3rem;
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        flex-shrink: 0;
    }

    .custom-textarea {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.9rem;
        background: #f8fafc;
        resize: none;
    }

    .custom-textarea:focus {
        outline: none;
        border-color: var(--primary-green);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .btn-send {
        background-color: var(--primary-green);
        color: white;
        border: none;
        padding: 8px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-top: 10px;
        float: right;
    }

    .comment-item {
        display: flex;
        gap: 16px;
        padding: 24px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .comment-author {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-main);
    }

    .comment-meta {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-left: 8px;
    }

    .admin-tag {
        background: #fee2e2;
        color: #ef4444;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        margin-right: 8px;
    }

    .comment-body {
        margin-top: 6px;
        line-height: 1.6;
        color: #334155;
        font-size: 0.92rem;
    }

    .interaction-bar {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 12px;
    }

    .btn-interact {
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    .btn-interact:hover { color: var(--primary-green); }
    .btn-interact.active { color: var(--primary-green); font-weight: 600; }

    .action-link {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
    }

    .action-link:hover { color: var(--primary-green); }
    .delete-link:hover { color: #ef4444; }
</style>

<div class="container py-5">
    <div class="product-info-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-2">{{ $product->nama_produk }}</h2>
                <p class="text-muted small mb-3">{{ $product->deskripsi }}</p>
                <div class="price-badge">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h5 class="section-title">
                Ulasan Pelanggan 
                <span class="badge rounded-pill bg-light text-dark fw-normal border" style="font-size: 0.7rem;">{{ $product->comments->count() }}</span>
            </h5>

            @auth
            <div class="comment-input-container">
                <div class="user-avatar shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <form action="{{ route('comments.store') }}" method="POST" class="textarea-wrapper">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <textarea name="content" class="custom-textarea" rows="2" placeholder="Bagikan ulasan ramah Anda..." required></textarea>
                    <button class="btn-send shadow-sm">Kirim Ulasan</button>
                </form>
            </div>
            @endauth

            <div class="comment-list-wrapper">
                @forelse($product->comments as $comment)
                <div class="comment-item">
                    <div class="user-avatar" style="background: #f1f5f9; color: var(--primary-green); font-size: 0.9rem;">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center">
                            <span class="comment-author">{{ $comment->user->name }}</span>
                            <span class="comment-meta">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="comment-body" id="text-{{ $comment->id }}">
                            @if($comment->user->role === 'admin')
                                <span class="admin-tag">Official</span>
                            @endif
                            {{ $comment->content }}
                        </div>

                        <div class="interaction-bar">
                            <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn-interact {{ $comment->likes > 0 ? 'active' : '' }}">
                                    <i class="bi bi-hand-thumbs-up{{ $comment->likes > 0 ? '-fill' : '' }}"></i> 
                                    <span>{{ $comment->likes }}</span>
                                </button>
                            </form>

                            <form action="{{ route('comments.dislike', $comment->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn-interact">
                                    <i class="bi bi-hand-thumbs-down"></i> 
                                    <span>{{ $comment->dislikes }}</span>
                                </button>
                            </form>

                            {{-- Tombol Edit di sini sudah dihapus sesuai permintaan --}}

                            @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-link delete-link" onclick="return confirm('Hapus ulasan?')">Hapus</button>
                            </form>
                            @endcan
                        </div>
                        
                        {{-- Form edit tetap ada di sini (hidden), 
                             bisa kamu panggil lewat fungsi JS jika nanti dibutuhkan --}}
                        @can('update', $comment)
                        <div id="edit-form-{{ $comment->id }}" class="mt-3 d-none">
                            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                @csrf @method('PUT')
                                <textarea name="content" class="form-control form-control-sm mb-2 shadow-none border-success" rows="2">{{ $comment->content }}</textarea>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-success px-3">Update</button>
                                    <button type="button" class="btn btn-sm btn-light border" onclick="toggleEdit({{ $comment->id }})">Batal</button>
                                </div>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
                @empty
                <div class="text-center py-5 border-top">
                    <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    function toggleEdit(id) {
        const form = document.getElementById('edit-form-' + id);
        if(form) {
            form.classList.toggle('d-none');
        }
    }
</script>
@endsection