@extends('layouts.main')

@section('title', 'Edit Profil')

@section('content')
{{-- Load Animate.css & FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .profile-section { padding: 60px 0; background: #f8fafc; min-height: 85vh; }
    
    .profile-card { 
        background: white; 
        border-radius: 24px; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.04); 
        border: 1px solid #e2e8f0; 
        overflow: hidden; 
        max-width: 800px; 
        margin: auto; 
        transition: transform 0.3s ease;
    }
    
    /* Header Background (Banner) */
    .profile-header { 
        height: 200px; /* Sedikit lebih tinggi biar enak dilihat */
        background: linear-gradient(135deg, #10b981, #059669); /* Default kalau gak ada gambar */
        background-size: cover;
        background-position: center;
        position: relative; 
    }

    /* Tombol Ganti Banner */
    .btn-change-banner {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 20;
    }

    .btn-change-banner:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: translateY(-2px);
    }
    
    /* Foto Profil Wrapper */
    .avatar-wrapper {
        width: 130px; height: 130px;
        background: white;
        border-radius: 50%;
        position: absolute;
        bottom: -65px; left: 50%;
        transform: translateX(-50%);
        padding: 5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 10;
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .avatar-wrapper:hover {
        transform: translateX(-50%) scale(1.05);
    }
    
    .avatar-img {
        width: 100%; height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #f1f5f9;
        transition: 0.3s;
    }
    .avatar-img:hover { filter: brightness(0.95); }

    /* Input File Sembunyi */
    .hidden-input { display: none; }
    
    .profile-body { padding: 90px 40px 40px 40px; }
    
    .form-label { font-weight: 600; font-size: 14px; color: #475569; margin-bottom: 8px; display: block; }
    .form-control { width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 14px; transition: 0.3s; }
    .form-control:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
    
    .btn-save { background: #10b981; color: white; border: none; padding: 14px 30px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.3s; display: block; width: 100%; margin-top: 20px; font-size: 16px; }
    .btn-save:hover { background: #059669; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.25); }

    .role-badge { 
        text-align: center; 
        margin-bottom: 30px; 
    }
    .role-badge span {
        background: #ecfdf5; color: #059669; 
        padding: 6px 16px; border-radius: 30px; 
        font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;
    }
</style>

<div class="profile-section">
    <div class="container">
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Animasi Card: Muncul dari bawah --}}
            <div class="profile-card animate__animated animate__fadeInUp">
                
                <!-- HEADER / BANNER -->
                <!-- Jika ada banner di DB, pakai itu. Jika tidak, pakai warna default -->
                <div class="profile-header" id="headerBanner" 
                     style="{{ auth()->user()->banner ? 'background-image: url(' . asset('storage/' . auth()->user()->banner) . ');' : '' }}">
                    
                    <!-- Tombol Ganti Banner -->
                    <button type="button" class="btn-change-banner" onclick="document.getElementById('bannerInput').click()">
                        <i class="fas fa-camera"></i> Ganti Sampul
                    </button>
                    <!-- Input Banner (Hidden) -->
                    <input type="file" name="banner" id="bannerInput" class="hidden-input" accept="image/*" onchange="previewBanner(this)">

                    {{-- AVATAR (FOTO PROFIL) --}}
                    <div class="avatar-wrapper animate__animated animate__zoomIn animate__delay-1s" onclick="document.getElementById('avatarInput').click()" title="Ganti Foto Profil">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="avatar-img" id="avatarPreview">
                        @else
                            {{-- Placeholder Inisial --}}
                            <div class="avatar-img" id="avatarPlaceholder" style="display: flex; align-items: center; justify-content: center; font-size: 45px; font-weight: 800; color: #64748b; background: #e2e8f0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            {{-- Image tag hidden buat preview nanti --}}
                            <img src="" class="avatar-img d-none" id="avatarPreviewReal" style="display: none;">
                        @endif
                    </div>
                    <!-- Input Avatar (Hidden) -->
                    <input type="file" name="avatar" id="avatarInput" class="hidden-input" accept="image/*" onchange="previewImage(this)">
                </div>

                <div class="profile-body">
                    {{-- Role Badge --}}
                    <div class="role-badge animate__animated animate__fadeInDown animate__delay-1s">
                        <span>{{ $user->role }} Account</span>
                    </div>

                    <div style="text-align: center; margin-bottom: 35px; color: #94a3b8; font-size: 13px;" class="animate__animated animate__fadeIn animate__delay-1s">
                        Klik foto profil atau sampul untuk mengubahnya
                    </div>

                    {{-- Form Utama --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px;" class="animate__animated animate__fadeInUp animate__delay-1s">
                        <div>
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    {{-- Form Password --}}
                    <div style="background: #fff7ed; padding: 25px; border-radius: 16px; border: 1px dashed #fdba74; margin-bottom: 30px;" class="animate__animated animate__fadeInUp animate__delay-2s">
                        <h5 style="margin: 0 0 20px 0; font-size: 15px; font-weight: 700; color: #ea580c; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-lock"></i> Ganti Password (Opsional)
                        </h5>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
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

                    {{-- Tombol Simpan --}}
                    <button type="submit" class="btn-save animate__animated animate__fadeInUp animate__delay-2s">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
    // Preview Foto Profil
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const placeholder = document.getElementById('avatarPlaceholder');
                if(placeholder) placeholder.style.display = 'none';

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

    // Preview Banner (Background Image)
    function previewBanner(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('headerBanner').style.backgroundImage = "url('" + e.target.result + "')";
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection