<nav class="navbar">
    <div class="container navbar-inner">

        <!-- BRAND -->
        <div class="navbar-brand">
            <div class="brand-logo">K</div>
            <span class="brand-text">KOPMA</span>
        </div>

        <!-- MENU -->
        <div class="navbar-menu">
            <a href="{{ url('/') }}" class="nav-link">Beranda</a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="nav-link">Produk</a>
                @else
                    <a href="{{ route('products.index') }}" class="nav-link">Produk</a>
                    <a href="{{ route('cart.index') }}" class="nav-link">Keranjang</a>
                @endif
            @endauth

            <a href="#" class="nav-link">Tentang</a>
        </div>

        <!-- ACTION -->
        <div class="navbar-action">
            @guest
                <a href="{{ route('login') }}" class="nav-login">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Daftar
                </a>
            @else
                <span class="nav-login">
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">Logout</button>
                </form>
            @endguest
        </div>

    </div>
</nav>
