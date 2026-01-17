@extends('layouts.main')

@section('content')
<div style="padding: 40px; background: #f9f9f9; min-height: 80vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="font-weight: 800; color: #2d3748; margin: 0;">Kelola Katalog Produk</h2>
        <a href="{{ route('admin.products.create') }}" style="background: #28a745; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">+ Tambah Produk</a>
    </div>

    @if(session('success'))
        <div style="background: #c6f6d5; color: #22543d; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #9ae6b4;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f4f7f6;">
                    <th style="padding: 18px; text-align: left; color: #718096; font-size: 0.75rem; text-transform: uppercase;">Gambar</th>
                    <th style="padding: 18px; text-align: left; color: #718096; font-size: 0.75rem; text-transform: uppercase;">Nama Produk</th>
                    <th style="padding: 18px; text-align: left; color: #718096; font-size: 0.75rem; text-transform: uppercase;">Harga</th>
                    <th style="padding: 18px; text-align: left; color: #718096; font-size: 0.75rem; text-transform: uppercase;">Stok</th>
                    <th style="padding: 18px; text-align: center; color: #718096; font-size: 0.75rem; text-transform: uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td style="padding: 15px;">
                        @if($p->gambar)
                            <img src="{{ asset('storage/' . $p->gambar) }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                        @else
                            <div style="width: 60px; height: 60px; background: #eee; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 10px;">No Pic</div>
                        @endif
                    </td>
                    <td style="padding: 15px;"><strong style="color: #2d3748;">{{ $p->nama_produk }}</strong></td>
                    <td style="padding: 15px;"><span style="background: #e6fffa; color: #28a745; padding: 6px 12px; border-radius: 20px; font-weight: bold;">Rp {{ number_format($p->harga, 0, ',', '.') }}</span></td>
                    <td style="padding: 15px; color: #4a5568;">{{ $p->stok }} Unit</td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('admin.products.edit', $p->id) }}" style="border: 1.5px solid #3182ce; color: #3182ce; padding: 6px 15px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">Edit</a>
                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="border: 1.5px solid #e53e3e; color: #e53e3e; padding: 6px 15px; border-radius: 6px; background: none; cursor: pointer; font-size: 0.85rem; font-weight: 600;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection