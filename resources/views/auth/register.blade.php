@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="auth-card">
    <h2 class="auth-title">Buat Akun Baru</h2>
    <p class="auth-subtitle">Daftar dan mulai pesan makanan sekarang</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input
                type="text"
                name="nama"
                class="form-control"
                placeholder="Masukkan nama lengkap"
                value="{{ old('nama') }}"
                required
                autofocus
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="contoh@email.com"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input
                    type="password"
                    name="password"
                    id="passwordInput"
                    class="form-control"
                    placeholder="Minimal 8 karakter"
                    required
                >
                <button type="button" class="btn-toggle-pass" onclick="togglePassword('passwordInput', 'toggleIcon1')">
                    <i class="bi bi-eye" id="toggleIcon1"></i>
                </button>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <input
                    type="password"
                    name="password_confirmation"
                    id="confirmInput"
                    class="form-control"
                    placeholder="Ulangi password"
                    required
                >
                <button type="button" class="btn-toggle-pass" onclick="togglePassword('confirmInput', 'toggleIcon2')">
                    <i class="bi bi-eye" id="toggleIcon2"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-auth">
            Daftar Sekarang
        </button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="/login">Masuk di sini</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endsection