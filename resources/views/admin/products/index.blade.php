@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div style="padding: 40px; background: #f9f9f9; min-height: 80vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="font-weight: 800; color: #2d3748; margin: 0; font-size: 28px;">
                Kelola Katalog Produk
            </h2>
            <p style="color: #718096; margin-top: 5px;">
                Total ada {{ count($products) }} produk terdaftar
            </p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           style="background: #28a745; color: white; padding: 12px 24px;
                  border-radius: 12px; text-decoration: none; font-weight: bold;
                  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
                  display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 20px;">+</span> Tambah Produk
        </a>
    </div>

    <div style="background: white; border-radius: 20px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.05);
                overflow: hidden; border: 1px solid #edf2f7;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #edf2f7;">
                    <th style="padding:20px;text-align:left;">Gambar</th>
                    <th style="padding:20px;text-align:left;">Nama Produk</th>
                    <th style="padding:20px;text-align:left;">Harga</th>
                    <th style="padding:20px;text-align:left;">Stok</th>
                    <th style="padding:20px;text-align:left;">Komentar</th>
                    <th style="padding:20px;text-align:center;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $p)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    
                    {{-- GAMBAR --}}
                    <td style="padding:15px;">
                        @if($p->gambar)
                            <img src="{{ asset('storage/'.$p->gambar) }}"
                                 style="width:70px;height:70px;object-fit:cover;
                                        border-radius:14px;">
                        @else
                            <div style="width:70px;height:70px;background:#f1f5f9;
                                        border-radius:14px;display:flex;
                                        align-items:center;justify-content:center;
                                        color:#94a3b8;font-size:11px;">
                                No Pic
                            </div>
                        @endif
                    </td>

                    {{-- NAMA --}}
                    <td style="padding:15px;">
                        <strong>{{ $p->nama_produk }}</strong><br>
                        <small style="color:#94a3b8;">ID: #PROD-{{ $p->id }}</small>
                    </td>

                    {{-- HARGA --}}
                    <td style="padding:15px;">
                        <span style="background:#ecfdf5;color:#059669;
                                     padding:6px 14px;border-radius:99px;
                                     font-weight:800;">
                            Rp {{ number_format($p->harga,0,',','.') }}
                        </span>
                    </td>

                    {{-- STOK --}}
                    <td style="padding:15px;">
                        {{ $p->stok }} Unit
                    </td>

                    {{-- PREVIEW KOMENTAR --}}
                    <td style="padding:15px;max-width:320px;">
                        @if($p->comments->count())
                            @foreach($p->comments->take(2) as $comment)
                                <div style="background:#f8fafc;
                                            padding:10px;
                                            border-radius:10px;
                                            margin-bottom:8px;">
                                    <strong style="font-size:13px;">
                                        {{ $comment->user->name }}
                                        @if($comment->user->role === 'admin')
                                            <span style="color:#dc2626;">(Admin)</span>
                                        @endif
                                    </strong>
                                    <p style="margin:5px 0;font-size:13px;color:#334155;">
                                        {{ \Illuminate\Support\Str::limit($comment->content, 70) }}
                                    </p>
                                    @if($comment->replies->count())
                                        <small style="color:#64748b;">
                                            {{ $comment->replies->count() }} balasan
                                        </small>
                                    @endif
                                </div>
                            @endforeach

                            @if($p->comments->count() > 2)
                                <small style="color:#64748b;">
                                    +{{ $p->comments->count() - 2 }} komentar lainnya
                                </small>
                            @endif
                        @else
                            <em style="color:#94a3b8;">Belum ada komentar</em>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td style="padding:15px;text-align:center;">
                        <div style="display:flex;gap:10px;justify-content:center;">
                            <a href="{{ route('admin.products.edit', $p->id) }}"
                               style="background:#eff6ff;color:#2563eb;
                                      padding:8px 18px;border-radius:10px;
                                      text-decoration:none;font-weight:700;">
                                Edit
                            </a>

                            <form id="delete-form-{{ $p->id }}"
                                  action="{{ route('admin.products.destroy', $p->id) }}"
                                  method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>

                            <button type="button"
                                    onclick="confirmDelete({{ $p->id }}, '{{ $p->nama_produk }}')"
                                    style="background:#fef2f2;color:#dc2626;
                                           padding:8px 18px;border-radius:10px;
                                           border:1px solid #fee2e2;
                                           font-weight:700;">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:50px;text-align:center;color:#94a3b8;">
                        Belum ada data produk di katalog.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Produk?',
        text: "Produk '" + name + "' akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2500
});
@endif
</script>
@endsection
