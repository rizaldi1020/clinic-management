<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Klinik Management</title>
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
        .brand-panel .logo { font-size: 3rem; margin-bottom: 1rem; }
        .brand-panel h1 { font-size: 1.75rem; font-weight: 700; margin-bottom: .5rem; text-align: center; }
        .brand-panel p { font-size: .95rem; opacity: .75; text-align: center; max-width: 280px; line-height: 1.6; }
        .features { margin-top: 2.5rem; display: flex; flex-direction: column; gap: .85rem; width: 100%; max-width: 280px; }
        .feature-item { display: flex; align-items: center; gap: .75rem; background: rgba(255,255,255,.1); border-radius: 10px; padding: .65rem 1rem; font-size: .875rem; }

        /* Panel kanan — form */
        .form-panel {
            width: 480px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 3rem;
            background: #fff;
            overflow-y: auto;
        }
        .form-panel h2 { font-size: 1.4rem; font-weight: 700; color: #1a202c; margin-bottom: .3rem; }
        .form-panel .subtitle { font-size: .875rem; color: #718096; margin-bottom: 1.5rem; }

        .section-title {
            font-size: .72rem; font-weight: 600; color: #718096;
            text-transform: uppercase; letter-spacing: .07em;
            margin: 1.1rem 0 .65rem; padding-bottom: .45rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
        .form-full { grid-column: 1 / -1; }
        .form-group { display: flex; flex-direction: column; gap: .3rem; }

        label { font-size: .82rem; font-weight: 500; color: #2d3748; }
        .required::after { content: ' *'; color: #e53e3e; }

        input, select, textarea {
            width: 100%;
            padding: .55rem .8rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: .875rem;
            font-family: inherit;
            color: #1a202c;
            transition: border-color .2s;
            outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #1a6db5;
            box-shadow: 0 0 0 3px rgba(26,109,181,.1);
        }
        .is-invalid { border-color: #fc8181 !important; }
        .invalid-msg { font-size: .75rem; color: #e53e3e; margin-top: .15rem; }

        .btn-register {
            width: 100%; padding: .7rem;
            background: #1a6db5; color: #fff;
            border: none; border-radius: 8px;
            font-size: .95rem; font-weight: 600;
            font-family: inherit; cursor: pointer;
            transition: background .2s;
            margin-top: 1.25rem;
        }
        .btn-register:hover { background: #155d9e; }

        .login-link {
            text-align: center; margin-top: 1rem;
            font-size: .875rem; color: #718096;
        }
        .login-link a { color: #1a6db5; text-decoration: none; font-weight: 500; }

        .alert-error {
            background: #fff5f5; border: 1px solid #feb2b2;
            border-radius: 8px; padding: .75rem 1rem;
            color: #c53030; font-size: .875rem;
            margin-bottom: 1rem;
        }

        /* Strength bar */
        #strength-bar { height: 4px; border-radius: 2px; background: #e2e8f0; margin-top: .3rem; transition: all .3s; }
        #strength-text { font-size: .72rem; margin-top: .15rem; }

        @media (max-width: 768px) {
            .brand-panel { display: none; }
            .form-panel { width: 100%; padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

{{-- Panel kiri --}}
<div class="brand-panel">
    <div class="logo">🏥</div>
    <h1>Klinik Management</h1>
    <p>Daftarkan diri Anda untuk menikmati layanan kesehatan digital kami</p>
    <div class="features">
        <div class="feature-item">📅 Booking janji temu online</div>
        <div class="feature-item">📋 Lihat rekam medis sendiri</div>
        <div class="feature-item">🧾 Cek tagihan kapan saja</div>
        <div class="feature-item">💊 Riwayat resep obat</div>
    </div>
</div>

{{-- Panel kanan --}}
<div class="form-panel">
    <h2>Buat Akun Baru</h2>
    <p class="subtitle">Isi data di bawah ini untuk mendaftar sebagai pasien</p>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        {{-- Akun Login --}}
        <div class="section-title">Akun Login</div>
        <div class="form-grid">
            <div class="form-group form-full">
                <label class="required">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Sesuai KTP"
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                @error('name')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group form-full">
                <label class="required">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="email@contoh.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                @error('email')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="required">Password</label>
                <input type="password" name="password" id="password"
                    oninput="checkStrength(this.value)"
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                <div id="strength-bar"></div>
                <div id="strength-text"></div>
                @error('password')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="required">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password">
            </div>
        </div>

        {{-- Data Diri --}}
        <div class="section-title">Data Diri Pasien</div>
        <div class="form-grid">
            <div class="form-group form-full">
                <label class="required">NIK (16 digit)</label>
                <input type="text" name="nik" value="{{ old('nik') }}"
                    placeholder="3578xxxxxxxxxxxxxxx" maxlength="16"
                    class="{{ $errors->has('nik') ? 'is-invalid' : '' }}">
                @error('nik')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="required">Jenis Kelamin</label>
                <select name="gender" class="{{ $errors->has('gender') ? 'is-invalid' : '' }}">
                    <option value="">— Pilih —</option>
                    <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Golongan Darah</label>
                <select name="blood_type">
                    @foreach(['-','A','B','AB','O'] as $bt)
                        <option value="{{ $bt }}" {{ old('blood_type','-') === $bt ? 'selected' : '' }}>
                            {{ $bt === '-' ? 'Tidak diketahui' : $bt }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="birth_place" value="{{ old('birth_place') }}" placeholder="Kota/Kabupaten">
            </div>
            <div class="form-group">
                <label class="required">Tanggal Lahir</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                    max="{{ date('Y-m-d') }}"
                    class="{{ $errors->has('birth_date') ? 'is-invalid' : '' }}">
                @error('birth_date')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>No. HP / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
            </div>
            <div class="form-group form-full">
                <label>Alamat Lengkap</label>
                <textarea name="address" rows="2" placeholder="Jl. ...">{{ old('address') }}</textarea>
            </div>
            <div class="form-group form-full">
                <label>Alergi (obat/makanan)</label>
                <input type="text" name="allergy" value="{{ old('allergy') }}"
                    placeholder="Contoh: Penisilin, seafood (kosongkan jika tidak ada)">
            </div>
        </div>

        <button type="submit" class="btn-register">🏥 Daftar Sekarang</button>
    </form>

    <div class="login-link">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
</div>

<script>
function checkStrength(val) {
    const bar  = document.getElementById('strength-bar');
    const text = document.getElementById('strength-text');
    if (!val) { bar.style.width='0'; text.textContent=''; return; }
    let score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        { w:'25%', color:'#e53e3e', label:'Lemah' },
        { w:'50%', color:'#dd6b20', label:'Cukup' },
        { w:'75%', color:'#d69e2e', label:'Baik' },
        { w:'100%',color:'#276749', label:'Kuat' },
    ];
    const lvl = levels[score - 1] || levels[0];
    bar.style.cssText  = `width:${lvl.w};background:${lvl.color};height:4px;border-radius:2px;transition:all .3s`;
    text.style.color   = lvl.color;
    text.textContent   = `Kekuatan: ${lvl.label}`;
}
</script>
</body>
</html>
