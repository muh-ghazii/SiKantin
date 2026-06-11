@extends('layouts.app')

@section('title', 'Pesanan')

@section('content')

<div class="page-header">
    <div>
        <h2>Pesanan</h2>
        <p>Kelola semua pesanan masuk</p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body" style="padding:16px 20px;">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" style="background:#fff; border-color:#e2e8f0;">
                        <i class="bi bi-search" style="color:#94a3b8;"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari nama pelanggan..." style="border-left:none;">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Daftar Pesanan</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Pelanggan</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th style="width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders ?? [] as $order)
                <tr>
                    <td class="text-muted">#{{ $order->id }}</td>
                    <td>
                        <div style="font-weight:500;">{{ $order->user->nama ?? '-' }}</div>
                        <div style="font-size:0.78rem; color:#94a3b8;">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td>
                        <span class="badge" style="background-color:#F1F5F9; color:#475569;">
                            {{ $order->order_items_count ?? 0 }} item
                        </span>
                    </td>
                    <td style="font-weight:500;">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="text-muted" style="font-size:0.8rem;">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td>
                        <a href="/orders/{{ $order->id }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-receipt" style="font-size:2rem; display:block; margin-bottom:8px; opacity:0.3;"></i>
                        Belum ada pesanan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection