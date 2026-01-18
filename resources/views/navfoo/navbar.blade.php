<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<nav style="background: white; padding: 18px 0; box-shadow: 0 4px 15px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 1000; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1200px; margin: auto; padding: 0 25px; display: flex; justify-content: space-between; align-items: center;">
        
        {{-- LOGO --}}
        <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
            <div style="background: #28a745; color: white; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 24px; box-shadow: 0 4px 12px rgba(40,167,69,0.3);">K</div>
            <span style="font-weight: 800; font-size: 26px; color: #1e293b; letter-spacing: -1px;">KOPMA</span>
        </a>

        {{-- MENU TENGAH --}}
        <div style="display: flex; align-items: center; gap: 35px;">
            <a href="/" style="text-decoration: none; color: #64748b; font-weight: 600; font-size: 16px; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">Beranda</a>
            
            @if(auth()->check() && auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: #28a745; font-weight: 700; font-size: 16px;">Dashboard Admin</a>
            @else
                <a href="/products" style="text-decoration: none; color: #64748b; font-weight: 600; font-size: 16px; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">Produk</a>
            @endif
            
            <a href="/tentang" style="text-decoration: none; color: #64748b; font-weight: 600; font-size: 16px; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">Tentang</a>
        </div>

        {{-- BAGIAN KANAN --}}
        <div style="display: flex; align-items: center; gap: 20px;">
            
            {{-- 1. TOMBOL DARK MODE (Opsional) --}}
            <button onclick="toggleTheme()" style="background: none; border: none; cursor: pointer; font-size: 20px; color: #64748b; transition: 0.3s;" title="Ganti Mode"
                    onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">
                <i class="fa-solid fa-circle-half-stroke"></i>
            </button>

            {{-- 2. IKON RIWAYAT (Hanya Customer) --}}
            @if(auth()->check() && auth()->user()->role == 'customer')
                <a href="{{ route('customer.transactions') }}" 
                   style="text-decoration: none; color: #1e293b; transition: 0.3s; display: flex; align-items: center;" 
                   onmouseover="this.style.color='#28a745'" 
                   onmouseout="this.style.color='#1e293b'"
                   title="Riwayat Pesanan">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size: 20px;"></i>
                </a>
            @endif
            
            {{-- 3. IKON KERANJANG (Hanya Customer/Guest) --}}
            @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'admin'))
                <a href="/cart" style="text-decoration: none; position: relative; color: #1e293b; transition: 0.3s; display: flex; align-items: center;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#1e293b'">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 22px;"></i>
                    <span style="position: absolute; top: -8px; right: -10px; background: #ef4444; color: white; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        {{ auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->sum('jumlah') : 0 }}
                    </span>
                </a>
            @endif

            {{-- PEMBATAS VERTICAL --}}
            <div style="width: 1px; height: 25px; background: #e2e8f0;"></div>

            {{-- 4. USER PROFILE & LOGOUT --}}
            @auth
                <div style="display: flex; align-items: center; gap: 15px;">
                    
                    {{-- Link ke Profil (Klik Nama/Foto untuk Edit Profil) --}}
                    <a href="{{ route('profile.edit') }}" style="text-decoration: none; display: flex; align-items: center; gap: 12px; transition: 0.3s;" title="Edit Profil">
                        <div style="text-align: right; line-height: 1.3;">
                            <span style="display: block; font-weight: 700; color: #1e293b; font-size: 14px;">{{ auth()->user()->name }}</span>
                            <span style="color: #28a745; font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 700; display: block;">{{ auth()->user()->role }}</span>
                        </div>
                        
                        {{-- FOTO PROFIL (Logic: Jika ada avatar tampilkan, jika tidak pakai inisial) --}}
                        <div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 2px solid #dcfce7; display: flex; align-items: center; justify-content: center; background: #f0fdf4;">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span style="color: #166534; font-weight: 700; font-size: 16px;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                    </a>
                    
                    {{-- Tombol Logout (Ikon Power) --}}
                    <form action="/logout" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; width: 35px; height: 35px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center;" 
                                onmouseover="this.style.background='#e11d48'; this.style.color='white'" onmouseout="this.style.background='#fff1f2'; this.style.color='#e11d48'" title="Keluar">
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                    </form>
                </div>
            @else
                {{-- TOMBOL MASUK/DAFTAR --}}
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="/login" style="text-decoration: none; color: #64748b; font-weight: 700; font-size: 15px;">Masuk</a>
                    <a href="/register" style="text-decoration: none; background: #28a745; color: white; padding: 10px 24px; border-radius: 12px; font-weight: 700; font-size: 15px; box-shadow: 0 6px 15px rgba(40,167,69,0.25); transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</nav>