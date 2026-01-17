@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div style="padding: 40px; background: #f9f9f9; min-height: 80vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="font-weight: 800; color: #2d3748; margin: 0; font-size: 28px;">Kelola Katalog Produk</h2>
            <p style="color: #718096; margin-top: 5px;">Total ada {{ count($products) }} produk terdaftar</p>
        </div>
        <a href="{{ route('admin.products.create') }}" style="background: #28a745; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: bold; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2); transition: 0.3s; display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 20px;">+</span> Tambah Produk
        </a>
    </div>

    <div style="background: white; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #edf2f7;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #edf2f7;">
                    <th style="padding: 20px; text-align: left; color: #4a5568; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Gambar</th>
                    <th style="padding: 20px; text-align: left; color: #4a5568; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Nama Produk</th>
                    <th style="padding: 20px; text-align: left; color: #4a5568; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Harga</th>
                    <th style="padding: 20px; text-align: left; color: #4a5568; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Stok</th>
                    <th style="padding: 20px; text-align: center; color: #4a5568; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;" onmouseover="this.style.background='#fcfdfd'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px;">
                        @if($p->gambar)
                            <img src="{{ asset('storage/' . $p->gambar) }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 14px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        @else
                            <div style="width: 70px; height: 70px; background: #f1f5f9; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 11px; font-weight: 600;">No Pic</div>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        <span style="display: block; font-weight: 700; color: #1e293b; font-size: 1rem;">{{ $p->nama_produk }}</span>
                        <small style="color: #94a3b8;">ID: #PROD-{{ $p->id }}</small>
                    </td>
                    <td style="padding: 15px;">
                        <span style="background: #ecfdf5; color: #059669; padding: 6px 14px; border-radius: 99px; font-weight: 800; font-size: 0.9rem;">
                            Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <span style="font-weight: 600; color: #475569;">{{ $p->stok }}</span>
                            <span style="color: #94a3b8; font-size: 0.8rem;">Unit</span>
                        </div>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; gap: 10px; justify-content: center;">
                            <a href="{{ route('admin.products.edit', $p->id) }}" style="background: #eff6ff; color: #2563eb; padding: 8px 18px; border-radius: 10px; text-decoration: none; font-size: 0.85rem; font-weight: 700; transition: 0.3s; border: 1px solid #dbeafe;">
                                Edit
                            </a>
                            
                            <form id="delete-form-{{ $p->id }}" action="{{ route('admin.products.destroy', $p->id) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                            
                            <button type="button" onclick="confirmDelete({{ $p->id }}, '{{ $p->nama_produk }}')" style="background: #fef2f2; color: #dc2626; padding: 8px 18px; border-radius: 10px; border: 1px solid #fee2e2; cursor: pointer; font-size: 0.85rem; font-weight: 700; transition: 0.3s;">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 50px; text-align: center; color: #94a3b8; font-style: italic;">
                        Belum ada data produk di katalog.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    // 1. Fungsi Konfirmasi Hapus
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Produk '" + name + "' akan dihapus permanen dari katalog!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Merah
            cancelButtonColor: '#64748b',  // Abu-abu
            confirmButtonText: 'Ya, Hapus Saja!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            borderRadius: '20px',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    // 2. Notifikasi Sukses (Jika ada session success)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500,
            borderRadius: '20px',
            showClass: {
                popup: 'animate__animated animate__zoomIn'
            }
        });
    @endif
</script>
@endsection