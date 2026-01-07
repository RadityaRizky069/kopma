<nav class="navbar">
    <div class="container navbar-inner">

        <!-- BRAND -->
        <div class="navbar-brand">
            <div class="brand-logo">K</div>
            <span class="brand-text">KOPMA</span>
        </div>

        <!-- MENU (bisa ditambah nanti) -->
        <div class="navbar-menu">
            <a href="#" class="nav-link active">Beranda</a>
            <a href="#" class="nav-link">Produk</a>
            <a href="#" class="nav-link">Tentang</a>
        </div>

        <!-- ACTION -->
        <div class="navbar-action">
            <a href="{{ route('login') }}" class="nav-login">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary">
                Daftar
            </a>
        </div>

    </div>
</nav>
