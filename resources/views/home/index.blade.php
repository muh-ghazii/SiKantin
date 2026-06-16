@extends('layouts.app')

@section('title', 'Daftar Menu')

@section('content')

<div class="page-header">
    <div>
        <h2>Daftar Menu</h2>
        <p>Pilih makanan dan minuman favoritmu</p>
    </div>
    @php $cartCount = collect(session('cart', []))->sum('jumlah'); @endphp
    <a href="/orders/create" class="btn btn-primary">
        <i class="bi bi-cart"></i> Keranjang
        @if($cartCount > 0)
            <span class="badge bg-white text-dark ms-1">{{ $cartCount }}</span>
        @endif
    </a>
</div>

<div class="d-flex gap-2 flex-wrap mb-4">
    <button class="btn btn-primary btn-sm category-btn active" data-category="all">
        Semua
    </button>
    @foreach($categories ?? [] as $cat)
    <button class="btn btn-secondary btn-sm category-btn" data-category="{{ $cat->id }}">
        {{ $cat->nama_kategori }}
    </button>
    @endforeach
</div>

<div class="mb-4" style="max-width:400px;">
    <div class="input-group">
        <span class="input-group-text" style="background:#fff; border-color:#e2e8f0;">
            <i class="bi bi-search" style="color:#94a3b8;"></i>
        </span>
        <input type="text" id="searchInput" class="form-control"
               placeholder="Cari menu..." style="border-left:none;">
    </div>
</div>

@if(session('cart_message'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('cart_message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-3" id="menuGrid">
    @forelse($menus ?? [] as $menu)
    <div class="col-sm-6 col-md-4 col-xl-3 menu-item" data-category="{{ $menu->category_id }}" data-name="{{ strtolower($menu->nama_menu) }}">
        <div class="card h-100">

            <div style="height:160px; overflow:hidden; border-radius:10px 10px 0 0;">
                @if($menu->gambar_url)
                    <img src="{{ asset('images/' . $menu->gambar_url) }}"
                         alt="{{ $menu->nama_menu }}"
                         style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div style="width:100%; height:100%; background:linear-gradient(135deg,#EFF6FF,#DBEAFE); display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-egg-fried" style="font-size:2.5rem; color:#93C5FD;"></i>
                    </div>
                @endif
            </div>

            <div class="card-body" style="padding:14px;">
                <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                    <h6 style="font-size:0.9rem; font-weight:600; margin:0; color:#0f172a;">
                        {{ $menu->nama_menu }}
                    </h6>
                    @if($menu->stok > 0)
                        <span class="badge badge-selesai flex-shrink-0">Tersedia</span>
                    @else
                        <span class="badge badge-dibatalkan flex-shrink-0">Habis</span>
                    @endif
                </div>

                <p style="font-size:0.78rem; color:#94a3b8; margin-bottom:10px; line-height:1.4;">
                    {{ Str::limit($menu->deskripsi ?? '-', 50) }}
                </p>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span style="font-size:1rem; font-weight:700; color:#f97316;">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </span>
                    <span style="font-size:0.75rem; color:#94a3b8;">
                        <i class="bi bi-tag"></i> {{ $menu->category->nama_kategori ?? '-' }}
                    </span>
                </div>

                @if($menu->stok > 0)
                <form action="/cart/add" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <input type="hidden" name="nama_menu" value="{{ $menu->nama_menu }}">
                    <input type="hidden" name="harga" value="{{ $menu->harga }}">
                    <input type="hidden" name="stok" value="{{ $menu->stok }}">
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" name="jumlah" value="1" min="1" max="{{ $menu->stok }}"
                               class="form-control form-control-sm text-center" style="width:65px;">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                            <i class="bi bi-cart-plus"></i> Tambah
                        </button>
                    </div>
                </form>
                @else
                <button class="btn btn-secondary btn-sm w-100" disabled>
                    <i class="bi bi-x-circle"></i> Stok Habis
                </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-5">
        <i class="bi bi-shop" style="font-size:3rem; display:block; margin-bottom:12px; opacity:0.2;"></i>
        <p>Belum ada menu tersedia</p>
    </div>
    @endforelse
</div>

@endsection

@section('styles')
<style>
    .category-btn.active {
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
        color: #fff !important;
    }
</style>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const cat = this.dataset.category;
            document.querySelectorAll('.menu-item').forEach(item => {
                item.style.display = (cat === 'all' || item.dataset.category === cat) ? '' : 'none';
            });
        });
    });

    document.getElementById('searchInput').addEventListener('input', function() {
        const val = this.value.toLowerCase();
        document.querySelectorAll('.menu-item').forEach(item => {
            item.style.display = item.dataset.name.includes(val) ? '' : 'none';
        });
    });
</script>
@endsection