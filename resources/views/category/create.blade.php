@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<div class="page-header">
    <div>
        <h2>Tambah Kategori</h2>
        <p>Buat kategori menu baru</p>
    </div>
    <a href="/categories" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Form Kategori</div>
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="/categories" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Nama Kategori</label>
                        <input
                            type="text"
                            name="nama_kategori"
                            class="form-control"
                            placeholder="contoh: Makanan Berat, Minuman, Snack"
                            value="{{ old('nama_kategori') }}"
                            required
                            autofocus
                        >
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Simpan
                        </button>
                        <a href="/categories" class="btn btn-secondary">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection