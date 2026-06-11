@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h2>Dashboard</h2>
        <p>Selamat datang kembali, {{ auth()->user()->nama ?? 'Admin' }}</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="stat-label">Total Pelanggan</span>
                <div class="stat-icon" style="background-color:#EFF6FF;">
                    <i class="bi bi-people" style="color:#2563EB;"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_pelanggan'] ?? 0 }}</div>
            <div class="stat-label mt-1">Pengguna terdaftar</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="stat-label">Total Menu</span>
                <div class="stat-icon" style="background-color:#FFF7ED;">
                    <i class="bi bi-grid" style="color:#f97316;"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_menu'] ?? 0 }}</div>
            <div class="stat-label mt-1">Menu tersedia</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="stat-label">Total Pesanan</span>
                <div class="stat-icon" style="background-color:#F0FDF4;">
                    <i class="bi bi-receipt" style="color:#10B981;"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_pesanan'] ?? 0 }}</div>
            <div class="stat-label mt-1">Semua pesanan</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="stat-label">Total Pendapatan</span>
                <div class="stat-icon" style="background-color:#FEF3C7;">
                    <i class="bi bi-cash-stack" style="color:#F59E0B;"></i>
                </div>
            </div>
            <div class="stat-value" style="font-size:1.3rem;">
                Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}
            </div>
            <div class="stat-label mt-1">Total pemasukan</div>
        </div>
    </div>
</div>

<div class="row g-3">

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span>Pesanan Terbaru</span>
                <a href="/orders" class="btn btn-secondary btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan_terbaru ?? [] as $pesanan)
                        <tr>
                            <td class="text-muted">#{{ $pesanan->id }}</td>
                            <td>{{ $pesanan->user->nama ?? '-' }}</td>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $pesanan->status }}">
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span>Menu Terlaris</span>
                <a href="/menus" class="btn btn-secondary btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menu_terlaris ?? [] as $menu)
                        <tr>
                            <td>{{ $menu->nama_menu }}</td>
                            <td>
                                <span class="badge" style="background-color:#EFF6FF; color:#2563EB;">
                                    {{ $menu->total_terjual ?? 0 }}x
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">
                                Belum ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection