@extends('layouts.main')

@section('content')
<div class="container py-5">
    {{-- BAGIAN PRODUK --}}
    <div class="row mb-5 shadow-sm p-4 bg-white rounded">
        <div class="col-md-6 mb-3">
            @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->nama_produk }}">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                    <span class="text-muted">Tidak ada gambar</span>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $product->nama_produk }}</li>
                </ol>
            </nav>
            <h2 class="fw-bold">{{ $product->nama_produk }}</h2>
            <h3 class="text-primary fw-bold mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</h3>
            <p class="text-secondary">{{ $product->deskripsi }}</p>
            <div class="mt-4">
                <button class="btn btn-primary btn-lg px-4"><i class="bi bi-cart-plus"></i> Tambah ke Keranjang</button>
            </div>
        </div>
    </div>

    <hr class="my-5">

    {{-- BAGIAN KOMENTAR --}}
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h4 class="mb-4 fw-bold text-dark">Komentar ({{ $product->comments->count() }})</h4>

            {{-- FORM KOMENTAR UTAMA --}}
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body">
                    @auth
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="form-floating mb-3">
                            <textarea name="content" class="form-control" placeholder="Tulis komentar..." id="floatingTextarea" style="height: 100px" required></textarea>
                            <label for="floatingTextarea text-muted">Bagikan pendapat Anda tentang produk ini...</label>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary px-4">Kirim Komentar</button>
                        </div>
                    </form>
                    @else
                    <div class="text-center py-3">
                        <p class="text-muted small mb-0 py-2 bg-light rounded">
                            Silakan <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Login</a> untuk memberikan komentar.
                        </p>
                    </div>
                    @endauth
                </div>
            </div>

            {{-- LIST KOMENTAR --}}
            @foreach($product->comments->where('parent_id', null) as $comment)
                <div class="comment-wrapper mb-4">
                    <div class="d-flex border-bottom pb-3">
                        {{-- Avatar Dummy --}}
                        <div class="flex-shrink-0">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">
                                    {{ $comment->user->name }}
                                    @if($comment->user->role === 'admin')
                                        <span class="badge bg-danger rounded-pill ms-1" style="font-size: 0.6rem;">Admin</span>
                                    @endif
                                </h6>
                                <small class="text-muted small">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            
                            <p class="mt-2 text-dark">{{ $comment->content }}</p>

                            {{-- INTERAKSI --}}
                            <div class="d-flex gap-3 align-items-center mt-2">
                                {{-- Like --}}
                                <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button class="btn btn-sm btn-light text-success border-0 px-2 rounded-pill shadow-sm" type="submit">
                                        👍 <small class="fw-bold">{{ $comment->likes }}</small>
                                    </button>
                                </form>

                                {{-- Reply Toggle --}}
                                @auth
                                <button class="btn btn-sm btn-link text-decoration-none p-0 text-muted" onclick="toggleForm('reply-{{ $comment->id }}')">
                                    <small class="fw-bold"><i class="bi bi-reply"></i> Balas</small>
                                </button>
                                @endauth

                                {{-- Edit/Delete (Hanya Pemilik) --}}
                                @can('update', $comment)
                                    <button class="btn btn-sm btn-link text-decoration-none p-0 text-warning" onclick="toggleForm('edit-{{ $comment->id }}')">
                                        <small class="fw-bold">Edit</small>
                                    </button>
                                @endcan

                                @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="m-0 d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-link text-decoration-none p-0 text-danger border-0" onclick="return confirm('Hapus?')">
                                        <small class="fw-bold text-danger">Hapus</small>
                                    </button>
                                </form>
                                @endcan
                            </div>

                            {{-- FORM EDIT (Tersembunyi) --}}
                            <div id="edit-{{ $comment->id }}" class="d-none mt-3">
                                <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="content" value="{{ $comment->content }}" class="form-control" required>
                                        <button class="btn btn-warning">Update</button>
                                    </div>
                                </form>
                            </div>

                            {{-- FORM BALAS (Tersembunyi) --}}
                            <div id="reply-{{ $comment->id }}" class="d-none mt-3">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <div class="input-group input-group-sm shadow-sm">
                                        <input type="text" name="content" class="form-control" placeholder="Tulis balasan..." required>
                                        <button class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            </div>

                            {{-- REPLIES --}}
                            @foreach($comment->replies as $reply)
                                <div class="d-flex mt-4 pt-3 border-start ps-3 bg-light rounded p-2 shadow-sm mb-2" style="border-left-width: 4px !important; border-left-color: #0d6efd !important;">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 fw-bold small">
                                            {{ $reply->user->name }}
                                            @if($reply->user->role === 'admin')
                                                <span class="badge bg-danger rounded-pill ms-1" style="font-size: 0.5rem;">Admin</span>
                                            @endif
                                        </h6>
                                        <p class="small text-dark mb-0">{{ $reply->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- JS untuk Toggle Form --}}
<script>
    function toggleForm(id) {
        let element = document.getElementById(id);
        if (element.classList.contains('d-none')) {
            element.classList.remove('d-none');
        } else {
            element.classList.add('d-none');
        }
    }
</script>
@endsection