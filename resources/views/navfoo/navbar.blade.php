<nav style="background: white; padding: 15px 0; box-shadow: 0 4px 12px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1200px; margin: auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
        
        <a href="/" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
            <div style="background: #28a745; color: white; width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 20px;">K</div>
            <span style="font-weight: 800; font-size: 22px; color: #1e293b; letter-spacing: -1px;">KOPMA</span>
        </a>

        <div style="display: flex; align-items: center; gap: 30px;">

            {{-- Admin Lihat Dashboard, Customer Lihat Produk --}}
            @if(auth()->check() && auth()->user()->role == 'admin')
                <a href="/admin" style="text-decoration: none; color: #28a745; font-weight: 700; font-size: 15px;">Dashboard Admin</a>
            @else
                <a href="/products" style="text-decoration: none; color: #64748b; font-weight: 600; font-size: 15px; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">Produk</a>
            @endif
            
            <a href="/tentang" style="text-decoration: none; color: #64748b; font-weight: 600; font-size: 15px; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#64748b'">Tentang</a>
        </div>

        <div style="display: flex; align-items: center; gap: 20px;">
            
            {{-- LOGIKA KERANJANG: Hanya muncul jika BUKAN admin --}}
            @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'admin'))
                <a href="/cart" style="text-decoration: none; position: relative; color: #1e293b; transition: 0.3s;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#1e293b'">
                    <i class="fa-solid fa-bag-shopping" style="font-size: 22px;"></i>
                    <span style="position: absolute; top: -8px; right: -10px; background: #ef4444; color: white; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 50%; border: 2px solid white;">
                        0
                    </span>
                </a>
                <div style="width: 1px; height: 25px; background: #e2e8f0; margin: 0 5px;"></div>
            @endif

            @auth
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="text-align: right;">
                        <span style="display: block; font-weight: 700; color: #1e293b; font-size: 13px;">{{ auth()->user()->name }}</span>
                        <small style="color: #94a3b8; font-size: 10px; text-transform: uppercase;">{{ auth()->user()->role }}</small>
                    </div>
                    <form action="/logout" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; padding: 8px 15px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 12px; transition: 0.3s;" onmouseover="this.style.background='#ef4444'; this.style.color='white'">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <a href="/login" style="text-decoration: none; background: #28a745; color: white; padding: 8px 20px; border-radius: 10px; font-weight: 700; font-size: 14px;">Masuk</a>
            @endauth
        </div>
    </div>
</nav>