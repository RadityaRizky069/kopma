<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #A8DADC;">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="/">
            KOPMA
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                @auth
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#">Produk</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#">
                            Keranjang 🛒
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Riwayat Transaksi</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light ms-2" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
