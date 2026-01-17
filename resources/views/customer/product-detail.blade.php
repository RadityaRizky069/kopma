@extends('layouts.main')
{{-- ganti layouts.app kalau layout kamu beda --}}

@section('content')
<div class="container">

    <h3>{{ $product->nama_produk }}</h3>
    <p>{{ $product->deskripsi }}</p>
    <p>Rp {{ number_format($product->harga) }}</p>

    <hr>

    <h5>Komentar</h5>

    @auth
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <textarea name="content" class="form-control" required></textarea>
        <button class="btn btn-primary mt-2">Kirim</button>
    </form>
    @else
        <p><a href="{{ route('login') }}">Login</a> untuk komentar</p>
    @endauth

    <hr>

    @foreach($product->comments as $comment)
        <div class="border p-2 mb-2">
            <strong>{{ $comment->user->name }}</strong>

            @if($comment->user->role === 'admin')
                <span class="badge bg-danger">Admin</span>
            @endif

            <p>{{ $comment->content }}</p>

            {{-- REPLY --}}
            @foreach($comment->replies as $reply)
                <div class="ms-4 border-start ps-2">
                    <strong>{{ $reply->user->name }}</strong>
                    <p>{{ $reply->content }}</p>
                </div>
            @endforeach

            {{-- FORM BALAS --}}
            @auth
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <input type="text"
                       name="content"
                       class="form-control mt-1"
                       placeholder="Balas..."
                       required>
            </form>
            @endauth
        </div>
    @endforeach

</div>
@endsection
