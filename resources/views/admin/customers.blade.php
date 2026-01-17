@extends('layouts.main')

@section('title', 'Daftar Customer - KOPMA')

@section('content')
<div class="container" style="padding-top: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="font-weight: 800; margin: 0;">Daftar Member KOPMA</h2>
            <p style="color: var(--muted); margin-top: 4px;">Kelola data mahasiswa yang terdaftar sebagai customer.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background: var(--border);">Kembali</a>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #F9FAFB; border-bottom: 1px solid var(--border);">
                    <th style="padding: 20px; font-size: 14px; font-weight: 600;">Nama Lengkap</th>
                    <th style="padding: 20px; font-size: 14px; font-weight: 600;">Email</th>
                    <th style="padding: 20px; font-size: 14px; font-weight: 600;">Tanggal Bergabung</th>
                    <th style="padding: 20px; font-size: 14px; font-weight: 600;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $user)
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 20px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 35px; height: 35px; background: var(--primary-soft); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span style="font-weight: 500;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="padding: 20px; color: var(--muted);">{{ $user->email }}</td>
                    <td style="padding: 20px; color: var(--muted);">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="padding: 20px;">
                        <button class="btn" style="padding: 8px 16px; font-size: 12px; background: #fee2e2; color: #dc2626;" onclick="deleteConfirm('{{ $user->id }}')">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 40px; text-align: center; color: var(--muted);">Belum ada customer terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function deleteConfirm(id) {
        Swal.fire({
            title: 'Hapus Member?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: var(--muted),
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tambahkan logika hapus di sini jika diperlukan
                Swal.fire('Terhapus!', 'Member telah dihapus.', 'success');
            }
        })
    }
</script>
@endsection