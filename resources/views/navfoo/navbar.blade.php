<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #A8DADC;">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="/">
            KOPMA
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                @auth
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/">Produk</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#">Keranjang</a>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-dark ms-2">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <a href="/login">Login</a>

                    <a href="/register">Register</a>

                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
