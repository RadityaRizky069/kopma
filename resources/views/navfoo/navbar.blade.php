<nav class="navbar" style="background: white; padding: 15px 0; box-shadow: 0 4px 12px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; font-family: 'Inter', sans-serif;">
    <div class="container navbar-inner" style="max-width: 1200px; margin: auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
        
        <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
            <div style="background: #15803D; color: white; width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 20px;">K</div>
            <span style="font-weight: 800; font-size: 22px; color: #1e293b; letter-spacing: -1px;">KOPMA</span>
        </a>

        <div style="display: flex; align-items: center; gap: 30px;">
            <a href="{{ route('home') }}" class="nav-link">Beranda</a>

            @auth
                {{-- Cek Role: Admin vs Customer --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color: #15803D; font-weight: 700;">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="nav-link">Produk</a>
                @else
                    <a href="{{ route('products.index') }}" class="nav-link">Produk</a>
                    <a href="{{ route('cart.index') }}" class="nav-link">Keranjang</a>
                @endif
            @endauth
            
            <a href="{{ route('tentang') }}" class="nav-link">Tentang</a>
        </div>

        <div class="navbar-action" style="display: flex; align-items: center; gap: 20px;">
            
            @guest
                {{-- JIKA BELUM LOGIN (Tamu) --}}
                <a href="{{ route('login') }}" class="nav-login" style="text-decoration: none; color: #1e293b; font-weight: 600;">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="background: #15803D; color: white; padding: 8px 20px; border-radius: 10px; text-decoration: none; font-weight: 600;">
                    Daftar
                </a>
            @else
                {{-- JIKA SUDAH LOGIN (User/Admin) --}}
                <div style="display: flex; align-items: center; gap: 12px;">
                    
                    {{-- Info Nama & Role (Dari codingan temanmu) --}}
                    <div style="text-align: right; line-height: 1.2;">
                        <span style="display: block; font-weight: 700; color: #1e293b; font-size: 14px;">
                            {{ auth()->user()->name }}
                        </span>
                        <small style="color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ auth()->user()->role }}
                        </small>
                    </div>

                    {{-- Tombol Logout --}}
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 8px 16px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 12px; transition: 0.2s;">
                            Logout
                        </button>
                    </form>
                </div>
            @endguest

        </div>
    </div>
</nav>