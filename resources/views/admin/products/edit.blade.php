@extends('layouts.main')

@section('content')
<div style="display:flex;justify-content:center;align-items:center;padding:50px 20px;background:#f3f4f6;min-height:100vh;">
    <div style="width:100%;max-width:550px;background:white;padding:40px;border-radius:20px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);">
        
        <h2 style="text-align:center;color:#1f2937;font-weight:800;font-size:24px;margin-bottom:30px;">
            Edit Data Produk
        </h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- NAMA --}}
            <label style="font-weight:600">Nama Produk</label>
            <input type="text" name="nama_produk"
                   value="{{ $product->nama_produk }}"
                   style="width:100%;padding:12px;border:1.5px solid #d1d5db;border-radius:10px;margin-bottom:20px"
                   required>

            {{-- HARGA & STOK --}}
            <div style="display:flex;gap:15px;margin-bottom:20px">
                <div style="flex:1">
                    <label style="font-weight:600">Harga (Rp)</label>
                    <input type="number" name="harga"
                           value="{{ $product->harga }}"
                           style="width:100%;padding:12px;border:1.5px solid #d1d5db;border-radius:10px"
                           required>
                </div>
                <div style="flex:1">
                    <label style="font-weight:600">Stok</label>
                    <input type="number" name="stok"
                           value="{{ $product->stok }}"
                           style="width:100%;padding:12px;border:1.5px solid #d1d5db;border-radius:10px"
                           required>
                </div>
            </div>

            {{-- 🔥 KATEGORI BEBAS --}}
            <label style="font-weight:600">Kategori</label>
            <input
                type="text"
                name="kategori"
                value="{{ $product->category->nama_kategori ?? '' }}"
                list="kategori-list"
                placeholder="Ketik atau pilih kategori"
                style="width:100%;padding:12px;border:1.5px solid #d1d5db;border-radius:10px;margin-bottom:20px"
                required
            >

            <datalist id="kategori-list">
                @foreach($categories as $c)
                    <option value="{{ $c->nama_kategori }}">
                @endforeach
            </datalist>

            {{-- FOTO --}}
            <label style="font-weight:600">Foto Saat Ini</label><br>
            @if($product->gambar)
                <img src="{{ asset('storage/'.$product->gambar) }}"
                     style="width:120px;height:120px;object-fit:cover;border-radius:12px;margin:10px 0">
            @else
                <p style="color:#9ca3af;font-size:14px">Belum ada foto</p>
            @endif

            <input type="file" name="gambar" style="margin-bottom:20px">

            {{-- DESKRIPSI --}}
            <label style="font-weight:600">Deskripsi</label>
            <textarea name="deskripsi" rows="4"
                      style="width:100%;padding:12px;border:1.5px solid #d1d5db;border-radius:10px;margin-bottom:30px">{{ $product->deskripsi }}</textarea>

            <button type="submit"
                    style="width:100%;background:#28a745;color:white;padding:15px;border:none;border-radius:12px;font-weight:700">
                Update Data Produk
            </button>

            <a href="{{ route('admin.products.index') }}"
               style="display:block;text-align:center;margin-top:20px;color:#6b7280;text-decoration:none">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection
