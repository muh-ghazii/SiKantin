@extends('layouts.app')

@section('title', 'Buat Pesanan')

@section('content')

<div class="page-header">
    <div>
        <h2>Buat Pesanan</h2>
        <p>Periksa pesananmu sebelum dikirim</p>
    </div>
    <a href="/home" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Tambah Menu Lagi
    </a>
</div>

@php $cart = session('cart', []); @endphp

@if(count($cart) === 0)
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="bi bi-cart-x" style="font-size:3rem; display:block; margin-bottom:12px; opacity:0.3;"></i>
            <p class="mb-3">Keranjang kamu masih kosong.</p>
            <a href="/home" class="btn btn-primary">
                <i class="bi bi-shop"></i> Lihat Menu
            </a>
        </div>
    </div>
@else
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Item Pesanan</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                            <th style="width:50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                        @php $subtotal = $item['harga'] * $item['jumlah']; $total += $subtotal; @endphp
                        <tr>
                            <td style="font-weight:500;">{{ $item['nama_menu'] }}</td>
                            <td class="text-center">
                                <form action="/cart/update" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $id }}">
                                    <input type="number" name="jumlah" value="{{ $item['jumlah'] }}"
                                           min="1" max="{{ $item['stok'] }}"
                                           class="form-control form-control-sm text-center d-inline-block"
                                           style="width:65px;"
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="text-end">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td class="text-end" style="font-weight:600; color:#f97316;">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <form action="/cart/remove" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $id }}">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus item ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Ringkasan Pesanan</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Item</span>
                    <span>{{ collect($cart)->sum('jumlah') }} item</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span style="font-weight:600;">Total Harga</span>
                    <span style="font-weight:700; color:#f97316; font-size:1.1rem;">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>

                <form action="/orders" method="POST">
                    @csrf
                    @foreach($cart as $id => $item)
                        <input type="hidden" name="items[{{ $id }}][menu_id]" value="{{ $id }}">
                        <input type="hidden" name="items[{{ $id }}][jumlah]" value="{{ $item['jumlah'] }}">
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2"
                                  placeholder="Contoh: Jangan pakai sayur"></textarea>
                    </div>

                    <button type="submit" class="btn btn-orange w-100">
                        <i class="bi bi-cart-check"></i> Pesan Sekarang
                    </button>
                </form>

                <form action="/cart/clear" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-secondary w-100"
                            onclick="return confirm('Kosongkan keranjang?')">
                        <i class="bi bi-trash"></i> Kosongkan Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection