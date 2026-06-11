<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiKantin') — Sistem Informasi Kantin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('styles')
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-brand">
            <span>Si<em>Kantin</em></span>
        </div>

        <div class="nav-label">Publik</div>
        <a href="/home" class="nav-link {{ request()->is('home*') ? 'active' : '' }}">
            <i class="bi bi-house"></i> Beranda
        </a>

        @auth
            @if(auth()->user()->role === 'admin')
                <div class="nav-label">Admin Panel</div>
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <div class="nav-label">Kelola</div>
                <a href="/categories" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Kategori
                </a>
                <a href="/menus" class="nav-link {{ request()->is('menus*') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Menu
                </a>
                <a href="/orders" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Pesanan
                </a>

            @else
                <div class="nav-label">Area Pelanggan</div>
                <a href="/orders/create" class="nav-link {{ request()->is('orders/create*') ? 'active' : '' }}">
                    <i class="bi bi-cart-plus"></i> Buat Pesanan
                </a>
                <a href="/orders/history" class="nav-link {{ request()->is('orders/history*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Riwayat Pesanan
                </a>
            @endif

            <div class="nav-label">Sistem</div>
            <a href="#" class="nav-link text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
            <form id="logout-form" action="/logout" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <div class="nav-label">Akun</div>
            <a href="/login" class="nav-link {{ request()->is('login') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
        @endauth
    </nav>

    <div id="topbar">
        <h1 class="page-title">@yield('title', 'Dashboard')</h1>

        <div class="d-flex align-items-center gap-3">
            @auth
            <div class="dropdown">
                <div class="d-flex align-items-center gap-2" style="cursor:pointer;" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                    </div>
                    <span class="user-name">{{ auth()->user()->nama }}</span>
                    <i class="bi bi-chevron-down" style="font-size:0.7rem; color:#999;"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </div>

    <div id="main-content">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>