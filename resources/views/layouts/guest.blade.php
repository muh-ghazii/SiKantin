<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiKantin') — Sistem Informasi Kantin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            min-height: 100vh;
            display: flex;
            background-color: #f1f5f9;
        }

        .auth-left {
            width: 45%;
            background-color: #1a3454;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background-color: rgba(249,115,22,0.08);
        }

        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background-color: rgba(37,99,235,0.1);
        }

        .auth-left .brand {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .auth-left .brand em {
            font-style: normal;
            color: #f97316;
        }

        .auth-left .tagline {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.55);
            text-align: center;
            line-height: 1.6;
            max-width: 280px;
            position: relative;
            z-index: 1;
            margin-bottom: 40px;
        }

        .auth-left .feature-list {
            list-style: none;
            width: 100%;
            max-width: 300px;
            position: relative;
            z-index: 1;
        }

        .auth-left .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .auth-left .feature-list li:last-child {
            border-bottom: none;
        }

        .auth-left .feature-list li i {
            color: #f97316;
            font-size: 1rem;
            width: 20px;
            flex-shrink: 0;
        }

        .auth-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            background-color: #f1f5f9;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background-color: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 36px 32px;
        }

        .auth-card .auth-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .auth-card .auth-subtitle {
            font-size: 0.835rem;
            color: #64748b;
            margin-bottom: 28px;
        }

        .form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 9px 13px;
            color: #0f172a;
            width: 100%;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
            outline: none;
        }

        .input-group .form-control {
            border-right: none;
            border-radius: 6px 0 0 6px;
        }

        .input-group .btn-toggle-pass {
            border: 1px solid #e2e8f0;
            border-left: none;
            background-color: #ffffff;
            border-radius: 0 6px 6px 0;
            padding: 0 13px;
            color: #64748b;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .input-group .btn-toggle-pass:hover {
            color: #2563EB;
        }

        .btn-auth {
            width: 100%;
            padding: 10px;
            background-color: #f97316;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 8px;
        }

        .btn-auth:hover {
            background-color: #ea6c0a;
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.835rem;
            color: #64748b;
        }

        .auth-footer a {
            color: #2563EB;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            border: none;
            border-radius: 6px;
            font-size: 0.835rem;
            padding: 10px 14px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #FEF2F2;
            color: #991B1B;
        }

        .alert-success {
            background-color: #ECFDF5;
            color: #065F46;
        }

        @media (max-width: 768px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                padding: 32px 20px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

    <div class="auth-left">
        <div class="brand">Si<em>Kantin</em></div>
        <p class="tagline">Sistem Informasi Kantin — Pesan makanan dengan mudah dan cepat.</p>

        <ul class="feature-list">
            <li>
                <i class="bi bi-shop"></i>
                Lihat menu kantin lengkap
            </li>
            <li>
                <i class="bi bi-cart-check"></i>
                Pesan makanan tanpa antri
            </li>
            <li>
                <i class="bi bi-clock-history"></i>
                Pantau status pesanan realtime
            </li>
            <li>
                <i class="bi bi-shield-check"></i>
                Data aman dan terpercaya
            </li>
        </ul>
    </div>

    <div class="auth-right">
        @if(session('success'))
            <div class="alert alert-success" style="width:100%; max-width:420px;">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="width:100%; max-width:420px;">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>