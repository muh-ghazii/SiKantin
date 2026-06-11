@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <h2 class="auth-title">Selamat Datang!</h2>
    <p class="auth-subtitle">Masuk ke akun SiKantin kamu</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="contoh@email.com"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input
                    type="password"
                    name="password"
                    id="passwordInput"
                    class="form-control"
                    placeholder="Masukkan password"
                    required
                >
                <button type="button" class="btn-toggle-pass" onclick="togglePassword()">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-auth">
            Masuk
        </button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="/register">Daftar sekarang</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');
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