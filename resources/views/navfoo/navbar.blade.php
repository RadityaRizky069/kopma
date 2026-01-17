<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<nav style="background: white; padding: 18px 0; box-shadow: 0 4px 15px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 1000; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1200px; margin: auto; padding: 0 25px; display: flex; justify-content: space-between; align-items: center;">
        
        {{-- LOGO --}}
        <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
            <div style="background: #28a745; color: white; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 24px; box-shadow: 0 4px 12px rgba(40,167,69,0.3);">K</div>
            <span style="font-weight: 800; font-size: 26px; color: #1e293b; letter-spacing: -1px;">KOPMA</span>
        </a>

        {{-- MENU TENGAH (Hanya Text Link) --}}
        <div style="display: flex; align-items: center; gap: 35px;">
            <a href="/" style="text-decoration: none; color: #64748b; font-weight: 600; font-size: 16px; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">Beranda</a>
            
            @if(auth()->check() && auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: #28a745; font-weight: 700; font-size: 16px;">Dashboard Admin</a>
            @else
                <a href="/products" style="text-decoration: none; color: #64748b; font-weight: 600; font-size: 16px; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">Produk</a>
            @endif
            
            <a href="/tentang" style="text-decoration: none; color: #64748b; font-weight: 600; font-size: 16px; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">Tentang</a>
        </div>

        {{-- BAGIAN KANAN (ICON GROUP & USER) --}}
        <div style="display: flex; align-items: center; gap: 25px;">
            
            {{-- 1. IKON RIWAYAT (BARU) - Hanya untuk Customer --}}
            @if(auth()->check() && auth()->user()->role == 'customer')
                <a href="{{ route('customer.transactions') }}" 
                   style="text-decoration: none; color: #1e293b; transition: 0.3s; display: flex; align-items: center;" 
                   onmouseover="this.style.color='#28a745'" 
                   onmouseout="this.style.color='#1e293b'"
                   title="Riwayat Pesanan">
                    {{-- Icon Jam/History --}}
                    <i class="fa-solid fa-clock-rotate-left" style="font-size: 22px;"></i>
                </a>
            @endif

            {{-- 2. IKON KERANJANG --}}
            @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'admin'))
                <a href="/cart" style="text-decoration: none; position: relative; color: #1e293b; transition: 0.3s; display: flex; align-items: center;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#1e293b'">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 24px;"></i>
                    <span style="position: absolute; top: -10px; right: -12px; background: #ef4444; color: white; font-size: 11px; font-weight: 800; padding: 3px 7px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        {{ auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->sum('jumlah') : 0 }}
                    </span>
                </a>
                
                {{-- Pembatas Garis --}}
                <div style="width: 1.5px; height: 30px; background: #e2e8f0;"></div>
            @endif

            {{-- 3. USER PROFILE / LOGIN --}}
            @auth
                <div style="display: flex; align-items: center; gap: 18px;">
                    <div style="text-align: right; line-height: 1.3;">
                        <span style="display: block; font-weight: 700; color: #1e293b; font-size: 15px;">{{ auth()->user()->name }}</span>
                        <span style="color: #28a745; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 700; display: block;">{{ auth()->user()->role }}</span>
                    </div>
                    
                    <form action="/logout" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; padding: 10px 18px; border-radius: 12px; font-weight: 700; cursor: pointer; font-size: 14px; transition: 0.3s; display: flex; align-items: center; gap: 8px;" 
                                onmouseover="this.style.background='#e11d48'; this.style.color='white'" onmouseout="this.style.background='#fff1f2'; this.style.color='#e11d48'">
                            <i class="fa-solid fa-power-off"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="/login" style="text-decoration: none; color: #64748b; font-weight: 700; font-size: 15px;">Masuk</a>
                    <a href="/register" style="text-decoration: none; background: #28a745; color: white; padding: 12px 26px; border-radius: 12px; font-weight: 700; font-size: 15px; box-shadow: 0 6px 15px rgba(40,167,69,0.25);">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</nav>