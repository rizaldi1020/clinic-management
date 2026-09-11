<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Klinik Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f0f4f8;
        }

        /* Panel kiri — branding */
        .brand-panel {
            flex: 1;
            background: linear-gradient(145deg, #0f4c81 0%, #1a6db5 60%, #2389d8 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            color: #fff;
        }
        .brand-panel .logo {
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }
        .brand-panel h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
        }
        .brand-panel p {
            font-size: 0.95rem;
            opacity: 0.75;
            text-align: center;
            max-width: 280px;
            line-height: 1.6;
        }
        .brand-panel .features {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 100%;
            max-width: 280px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
        .feature-item .icon { font-size: 1.25rem; }

        /* Panel kanan — form */
        .form-panel {
            width: 440px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            background: #fff;
        }
        .form-panel h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.4rem;
        }
        .form-panel .subtitle {
            font-size: 0.875rem;
            color: #718096;
            margin-bottom: 2rem;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            color: #c53030;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }
        .alert-success {
            background: #f0fff4;
            border: 1px solid #9ae6b4;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            color: #276749;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }
        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #2d3748;
            margin-bottom: 0.4rem;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.65rem 0.9rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: inherit;
            color: #1a202c;
            transition: border-color 0.2s;
            outline: none;
        }
        input:focus {
            border-color: #1a6db5;
            box-shadow: 0 0 0 3px rgba(26,109,181,0.12);
        }
        .input-error { border-color: #fc8181 !important; }
        .error-msg {
            color: #e53e3e;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        .row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            color: #4a5568;
            cursor: pointer;
        }
        input[type="checkbox"] { accent-color: #1a6db5; width: 15px; height: 15px; }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: #1a6db5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-login:hover  { background: #155d9e; }
        .btn-login:active { transform: scale(0.99); }

        .divider {
            text-align: center;
            margin: 2rem 0 1rem;
            font-size: 0.8rem;
            color: #a0aec0;
        }
        .demo-accounts {
            background: #f7fafc;
            border-radius: 10px;
            padding: 1rem 1.1rem;
        }
        .demo-accounts p {
            font-size: 0.78rem;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.6rem;
        }
        .demo-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.82rem;
            color: #4a5568;
            padding: 0.2rem 0;
        }
        .demo-item span { color: #a0aec0; }

        @media (max-width: 700px) {
            .brand-panel { display: none; }
            .form-panel  { width: 100%; padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

{{-- Panel kiri --}}
<div class="brand-panel">
    <div class="logo">🏥</div>
    <h1>Klinik Management</h1>
    <p>Sistem manajemen klinik terpadu untuk pelayanan kesehatan yang lebih baik</p>
    <div class="features">
        <div class="feature-item"><span class="icon">👥</span> Manajemen Data Pasien</div>
        <div class="feature-item"><span class="icon">📅</span> Jadwal & Janji Temu</div>
        <div class="feature-item"><span class="icon">📋</span> Rekam Medis Digital</div>
        <div class="feature-item"><span class="icon">💊</span> Manajemen Obat & Resep</div>
        <div class="feature-item"><span class="icon">💳</span> Tagihan & Pembayaran</div>
    </div>
</div>

{{-- Panel kanan — form --}}
<div class="form-panel">
    <h2>Selamat datang</h2>
    <p class="subtitle">Masukkan akun Anda untuk melanjutkan</p>

    {{-- Notifikasi logout --}}
    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error umum --}}
    @if ($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="contoh@email.com"
                autocomplete="email"
                class="{{ $errors->has('email') ? 'input-error' : '' }}"
                required
                autofocus
            >
            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                autocomplete="current-password"
                required
            >
        </div>

        <div class="row-between">
            <label class="checkbox-label">
                <input type="checkbox" name="remember" id="remember">
                Ingat saya
            </label>
        </div>

        <button type="submit" class="btn-login">Masuk</button>
    </form>

    <div class="divider">Akun demo untuk testing</div>
    <div class="demo-accounts">
        <p>Email / Password: password</p>
        <div class="demo-item">Admin        <span>admin@klinik.com</span></div>
        <div class="demo-item">Dokter       <span>dokter@klinik.com</span></div>
        <div class="demo-item">Resepsionis  <span>resepsionis@klinik.com</span></div>
        <div class="demo-item">Apoteker     <span>apoteker@klinik.com</span></div>
        <div class="demo-item">Kasir        <span>kasir@klinik.com</span></div>
    </div>
</div>

</body>
</html>
