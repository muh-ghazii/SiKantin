@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="page-header">
    <div>
        <h2>Riwayat Pesanan Anda</h2>
        <p>Daftar semua transaksi yang pernah Anda lakukan</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    <tr>
                        <td><strong>#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $order->orderItems->sum('jumlah') ?? 0 }} Item</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="/orders/{{ $order->id }}" class="btn btn-secondary">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection