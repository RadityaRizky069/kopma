@extends('layouts.main')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; padding: 50px 20px; background: #f3f4f6; min-height: 100vh; font-family: sans-serif;">
    <div style="width: 100%; max-width: 550px; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        
        <h2 style="text-align: center; color: #1f2937; font-weight: 800; font-size: 24px; margin-bottom: 30px; letter-spacing: -0.5px;">Edit Data Produk</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ $product->nama_produk }}" style="width: 100%; padding: 12px; border: 1.5px solid #d1d5db; border-radius: 10px; box-sizing: border-box; outline: none; transition: 0.3s;" required>
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ $product->harga }}" style="width: 100%; padding: 12px; border: 1.5px solid #d1d5db; border-radius: 10px; box-sizing: border-box; outline: none;" required>
                </div>
                <div style="flex: 0.5;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Stok</label>
                    <input type="number" name="stok" value="{{ $product->stok }}" style="width: 100%; padding: 12px; border: 1.5px solid #d1d5db; border-radius: 10px; box-sizing: border-box; outline: none;" required>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Kategori</label>
                <select name="kategori_id" style="width: 100%; padding: 12px; border: 1.5px solid #d1d5db; border-radius: 10px; background: white; outline: none;">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ $product->kategori_id == $c->id ? 'selected':'' }}>{{ $c->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Foto Saat Ini</label>
                @if($product->gambar)
                    <img src="{{ asset('storage/'.$product->gambar) }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 15px; border: 2px solid #f3f4f6; margin-bottom: 10px;">
                @else
                    <p style="color: #9ca3af; font-size: 14px; margin-bottom: 10px;">Belum ada foto.</p>
                @endif
                <input type="file" name="gambar" style="width: 100%; font-size: 14px; color: #6b7280;">
                <small style="color: #9ca3af; display: block; mt-1;">Biarkan kosong jika tidak ingin mengganti foto</small>
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Deskripsi</label>
                <textarea name="deskripsi" rows="3" style="width: 100%; padding: 12px; border: 1.5px solid #d1d5db; border-radius: 10px; box-sizing: border-box; outline: none; resize: vertical;">{{ $product->deskripsi }}</textarea>
            </div>

            <button type="submit" style="width: 100%; background: #28a745; color: white; padding: 15px; border: none; border-radius: 12px; font-weight: bold; font-size: 16px; cursor: pointer; transition: 0.3s;">Update Data Produk</button>
            
            <a href="{{ route('admin.products.index') }}" style="display: block; text-align: center; margin-top: 20px; color: #6b7280; text-decoration: none; font-size: 14px; font-weight: 600;">Kembali ke Daftar Produk</a>
        </form>
    </div>
</div>
@endsection