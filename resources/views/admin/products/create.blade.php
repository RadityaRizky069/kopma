@extends('layouts.main')

@section('content')
<style>
    .form-wrapper {
        max-width: 650px;
        margin: 50px auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    }
    .form-title {
        font-weight: 800;
        text-align: center;
        color: #2d3748;
        margin-bottom: 30px;
    }
    .label-style {
        display: block;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    .input-style {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #edf2f7;
        border-radius: 10px;
        margin-bottom: 20px;
        outline: none;
        transition: 0.3s;
    }
    .input-style:focus {
        border-color: #28a745;
    }
    .btn-submit-full {
        width: 100%;
        background: #28a745;
        color: white;
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-submit-full:hover {
        background: #218838;
        transform: translateY(-2px);
    }
</style>

<div class="form-wrapper">
    <h2 class="form-title">Tambah Produk Baru</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="label-style">Nama Produk</label>
        <input type="text" name="nama_produk" class="input-style" required>

        <div style="display:flex;gap:20px">
            <div style="flex:1">
                <label class="label-style">Harga (Rp)</label>
                <input type="number" name="harga" class="input-style" required>
            </div>
            <div style="flex:1">
                <label class="label-style">Stok</label>
                <input type="number" name="stok" class="input-style" required>
            </div>
        </div>

        {{-- 🔥 INI BAGIAN PENTING --}}
        <label class="label-style">Kategori</label>
        <input
            type="text"
            name="kategori"
            class="input-style"
            list="kategori-list"
            placeholder="Ketik atau pilih kategori"
            required
        >

        <datalist id="kategori-list">
            @foreach($categories as $c)
                <option value="{{ $c->nama_kategori }}">
            @endforeach
        </datalist>

        <label class="label-style">Unggah Foto Produk</label>
        <input type="file" name="gambar" class="input-style" accept="image/*">

        <label class="label-style">Deskripsi</label>
        <textarea name="deskripsi" class="input-style" rows="4"></textarea>

        <button type="submit" class="btn-submit-full">
            Simpan ke Dashboard
        </button>

        <a href="{{ route('admin.products.index') }}"
           style="display:block;text-align:center;margin-top:20px;color:#a0aec0;text-decoration:none;">
            Batal dan Kembali
        </a>
    </form>
</div>
@endsection
