@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="page-header">
    <div>
        <h2>Detail Pesanan <span style="color: var(--secondary)">#ORD-{{ isset($order) ? str_pad($order->id, 3, '0', STR_PAD_LEFT) : '000' }}</span></h2>
        <p>Rincian pesanan pelanggan</p>
    </div>
    <a href="{{ auth()->user()->role === 'admin' ? '/orders' : '/orders/history' }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                Informasi Pelanggan
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Nama:</strong> {{ $order->user->nama ?? 'Nama Pelanggan' }}</p>
                <p class="mb-2"><strong>Waktu Pesan:</strong> {{ isset($order) ? $order->created_at->format('d M Y, H:i') : '-' }}</p>
                @if(!empty($order->catatan))
                    <p class="mb-2"><strong>Catatan:</strong> {{ $order->catatan }}</p>
                @endif
                <p class="mb-3"><strong>Status Saat Ini:</strong> 
                    <span class="badge badge-{{ isset($order) ? strtolower($order->status) : 'pending' }}">
                        {{ isset($order) ? ucfirst($order->status) : 'Pending' }}
                    </span>
                </p>
                
                @if(auth()->user()->role === 'admin')
                <hr style="border-color: var(--border);">
                <form action="/orders/{{ $order->id }}/status" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Update Status</label>
                    <div class="input-group">
                        <select class="form-select" name="status">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <button class="btn btn-primary" type="submit" style="border-radius: 0 6px 6px 0;">Simpan</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                Rincian Item
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($order) && $order->orderItems)
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->menu->nama_menu ?? 'Item Dihapus' }}</td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="text-center">Data item tidak tersedia</td></tr>
                            @endif
                        </tbody>
                        <tfoot style="background-color: #fafbfc;">
                            <tr>
                                <th colspan="3" class="text-end py-3">Total Pembayaran:</th>
                                <th class="text-end py-3 fs-5" style="color: var(--secondary); border-bottom: none;">
                                    Rp {{ isset($order) ? number_format($order->total_harga, 0, ',', '.') : '0' }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection