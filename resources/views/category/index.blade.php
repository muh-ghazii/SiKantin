@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="page-header">
    <div>
        <h2>Kategori</h2>
        <p>Kelola kategori menu kantin</p>
    </div>
    <a href="/categories/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-header">
        Daftar Kategori
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Menu</th>
                    <th>Dibuat</th>
                    <th style="width:140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories ?? [] as $category)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px; height:32px; background-color:#EFF6FF; border-radius:6px; display:flex; align-items:center; justify-content:center;">
                                <i class="bi bi-tag" style="color:#2563EB; font-size:0.85rem;"></i>
                            </div>
                            <span style="font-weight:500;">{{ $category->nama_kategori }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background-color:#EFF6FF; color:#2563EB;">
                            {{ $category->menus_count ?? 0 }} menu
                        </span>
                    </td>
                    <td class="text-muted">{{ $category->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="/categories/{{ $category->id }}/edit" class="btn btn-secondary btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="/categories/{{ $category->id }}" method="POST"
                                  onsubmit="return confirm('Hapus kategori ini?')">
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
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-tag" style="font-size:2rem; display:block; margin-bottom:8px; opacity:0.3;"></i>
                        Belum ada kategori. <a href="/categories/create">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection