@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<div class="page-header">
    <div>
        <h2>Menu</h2>
        <p>Kelola daftar menu kantin</p>
    </div>
    <a href="/menus/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Menu
    </a>
</div>

<div class="card mb-4">
    <div class="card-body" style="padding:16px 20px;">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text" style="background:#fff; border-color:#e2e8f0;">
                        <i class="bi bi-search" style="color:#94a3b8;"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control"
                           placeholder="Cari nama menu..." style="border-left:none;">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="categoryFilter">
                    <option value="">Semua Kategori</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Daftar Menu</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th style="width:140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus ?? [] as $menu)
                <tr class="menu-row"
                    data-category="{{ $menu->category_id }}"
                    data-name="{{ strtolower($menu->nama_menu) }}">
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($menu->gambar_url)
                                <img src="{{ filter_var($menu->gambar_url, FILTER_VALIDATE_URL) ? $menu->gambar_url : asset('images/' . $menu->gambar_url) }}"
                                     alt="{{ $menu->nama_menu }}"
                                     style="width:40px; height:40px; border-radius:8px; object-fit:cover;">
                            @else
                                <div style="width:40px; height:40px; background-color:#F1F5F9; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-image" style="color:#94a3b8;"></i>
                                </div>
                            @endif
                            <div>
                                <div style="font-weight:500;">{{ $menu->nama_menu }}</div>
                                <div style="font-size:0.78rem; color:#94a3b8;">{{ Str::limit($menu->deskripsi, 40) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background-color:#EFF6FF; color:#2563EB;">
                            {{ $menu->category->nama_kategori ?? '-' }}
                        </span>
                    </td>
                    <td style="font-weight:500;">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($menu->stok > 0)
                            <span class="badge badge-selesai">{{ $menu->stok }}</span>
                        @else
                            <span class="badge badge-dibatalkan">Habis</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="/menus/{{ $menu->id }}/edit" class="btn btn-secondary btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="/menus/{{ $menu->id }}" method="POST"
                                  onsubmit="return confirm('Hapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-grid" style="font-size:2rem; display:block; margin-bottom:8px; opacity:0.3;"></i>
                        Belum ada menu. <a href="/menus/create">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');

    function filterRows() {
        const search = searchInput.value.toLowerCase();
        const category = categoryFilter.value;

        document.querySelectorAll('.menu-row').forEach(row => {
            const matchName = row.dataset.name.includes(search);
            const matchCategory = category === '' || row.dataset.category === category;
            row.style.display = (matchName && matchCategory) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterRows);
    categoryFilter.addEventListener('change', filterRows);
</script>
@endsection