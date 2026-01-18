@extends('layouts.main')

@section('title', 'Edit Profil')

@section('content')
<style>
    .profile-section { padding: 60px 0; background: #f8fafc; min-height: 85vh; }
    .profile-card { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; overflow: hidden; max-width: 800px; margin: auto; }
    
    /* Header Background */
    .profile-header { height: 150px; background: linear-gradient(135deg, #10b981, #059669); position: relative; }
    
    /* Foto Profil Wrapper */
    .avatar-wrapper {
        width: 120px; height: 120px;
        background: white;
        border-radius: 50%;
        position: absolute;
        bottom: -60px; left: 50%;
        transform: translateX(-50%);
        padding: 5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .avatar-img {
        width: 100%; height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #f1f5f9;
        cursor: pointer;
        transition: 0.3s;
    }
    .avatar-img:hover { filter: brightness(0.9); }

    /* Input File Sembunyi */
    #avatarInput { display: none; }
    
    .profile-body { padding: 80px 40px 40px 40px; }
    
    .form-label { font-weight: 600; font-size: 14px; color: #475569; margin-bottom: 8px; display: block; }
    .form-control { width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 14px; transition: 0.3s; }
    .form-control:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1); }
    
    .btn-save { background: #10b981; color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; display: block; width: 100%; margin-top: 20px; }
    .btn-save:hover { background: #059669; transform: translateY(-2px); }

    .role-badge { 
        text-align: center; 
        margin-bottom: 30px; 
    }
    .role-badge span {
        background: #ecfdf5; color: #059669; 
        padding: 5px 15px; border-radius: 20px; 
        font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
    }
</style>

<div class="profile-section">
    <div class="container">
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="profile-card">
                <!-- Header Warna Hijau -->
                <div class="profile-header">
                    <div class="avatar-wrapper" onclick="document.getElementById('avatarInput').click()">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="avatar-img" id="avatarPreview">
                        @else
                            {{-- Placeholder Inisial --}}
                            <div class="avatar-img" id="avatarPlaceholder" style="display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 800; color: #64748b; background: #e2e8f0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            {{-- Image tag hidden buat preview nanti --}}
                            <img src="" class="avatar-img d-none" id="avatarPreviewReal" style="display: none;">
                        @endif
                    </div>
                    <!-- Input File Tersembunyi -->
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" onchange="previewImage(this)">
                </div>

                <div class="profile-body">
                    <div class="role-badge">
                        <span>{{ $user->role }} Account</span>
                    </div>

                    <div style="text-align: center; margin-bottom: 30px; color: #94a3b8; font-size: 13px;">
                        Klik foto di atas untuk mengganti gambar profil
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div style="background: #fff7ed; padding: 20px; border-radius: 12px; border: 1px dashed #fdba74; margin-bottom: 20px;">
                        <h5 style="margin: 0 0 15px 0; font-size: 14px; color: #c2410c;">Ganti Password (Opsional)</h5>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
                            </div>
                            <div>
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
    // Script buat preview gambar sebelum di-upload
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Sembunyikan placeholder inisial
                const placeholder = document.getElementById('avatarPlaceholder');
                if(placeholder) placeholder.style.display = 'none';

                // Tampilkan gambar di tag img
                let img = document.getElementById('avatarPreview');
                if(!img) {
                    img = document.getElementById('avatarPreviewReal');
                    img.style.display = 'block';
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection