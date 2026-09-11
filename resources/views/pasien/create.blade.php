@extends('layouts.app')

@section('title', 'Tambah Pasien')
@section('page-title', 'Tambah Pasien Baru')
@section('breadcrumb', 'Admin / Pasien / Tambah')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('admin.users') }}"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="{{ route('departemen.index') }}"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}" class="active"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .form-full  { grid-column:1/-1; }
    .form-group { display:flex; flex-direction:column; gap:.35rem; }
    label { font-size:.875rem; font-weight:500; color:#2d3748; }
    .required::after { content:' *'; color:#e53e3e; }
    input, select, textarea {
        padding:.6rem .85rem; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:.875rem; font-family:inherit; color:#1a202c;
        transition:border-color .2s; outline:none;
    }
    input:focus, select:focus, textarea:focus {
        border-color:#1a6db5; box-shadow:0 0 0 3px rgba(26,109,181,.1);
    }
    .is-invalid { border-color:#fc8181 !important; }
    .invalid-msg { font-size:.8rem; color:#e53e3e; margin-top:.2rem; }
    .form-actions { display:flex; gap:.75rem; justify-content:flex-end; margin-top:1.25rem; padding-top:1.25rem; border-top:1px solid #e2e8f0; }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.6rem 1.25rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:background .15s; }
    .btn-primary { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
    .section-title { font-size:.8rem; font-weight:600; color:#718096; text-transform:uppercase; letter-spacing:.07em; margin:1.25rem 0 .75rem; padding-bottom:.5rem; border-bottom:1px solid #e2e8f0; }
</style>
@endpush

@section('content')
<div class="card" style="max-width:800px">

    <form method="POST" action="{{ route('pasien.store') }}">
        @csrf

        <p class="section-title">Identitas Pasien</p>
        <div class="form-grid">

            <div class="form-group">
                <label class="required">No. Rekam Medis</label>
                <input type="text" name="no_rm" value="{{ old('no_rm') }}"
                    placeholder="Contoh: RM-2024-001"
                    class="{{ $errors->has('no_rm') ? 'is-invalid' : '' }}">
                @error('no_rm')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="required">NIK (16 digit)</label>
                <input type="text" name="nik" value="{{ old('nik') }}"
                    placeholder="3578xxxxxxxxxxxxxxx" maxlength="16"
                    class="{{ $errors->has('nik') ? 'is-invalid' : '' }}">
                @error('nik')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group form-full">
                <label class="required">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Nama sesuai KTP"
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                @error('name')<p class="invalid-msg">{{ $message }}</p>@enderror
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
                    <option value="-"  {{ old('blood_type', '-') === '-'  ? 'selected' : '' }}>Tidak diketahui</option>
                    <option value="A"  {{ old('blood_type') === 'A'  ? 'selected' : '' }}>A</option>
                    <option value="B"  {{ old('blood_type') === 'B'  ? 'selected' : '' }}>B</option>
                    <option value="AB" {{ old('blood_type') === 'AB' ? 'selected' : '' }}>AB</option>
                    <option value="O"  {{ old('blood_type') === 'O'  ? 'selected' : '' }}>O</option>
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
                <label>Alamat</label>
                <textarea name="address" rows="2" placeholder="Alamat lengkap pasien">{{ old('address') }}</textarea>
            </div>

            <div class="form-group form-full">
                <label>Alergi (obat/makanan)</label>
                <textarea name="allergy" rows="2" placeholder="Contoh: Alergi penisilin, alergi seafood">{{ old('allergy') }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Pasien</button>
        </div>
    </form>

</div>
@endsection
