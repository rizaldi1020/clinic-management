@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')
@section('breadcrumb', 'Admin / Manajemen User / Tambah')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('user.index') }}" class="active"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="{{ route('departemen.index') }}"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-weight: 500; margin-bottom: .5rem; color: #4a5568; }
    .form-control { width: 100%; padding: .65rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: .875rem; font-family: inherit; transition: all .2s; }
    .form-control:focus { border-color: #1a6db5; outline: none; box-shadow: 0 0 0 3px rgba(26,109,181,.1); }
    .text-danger { color: #e53e3e; font-size: .75rem; margin-top: .25rem; display: block; }
    
    .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .6rem 1.25rem; border-radius: 8px; font-size: .875rem; font-family: inherit; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: background .15s; }
    .btn-primary { background: #1a6db5; color: #fff; }
    .btn-primary:hover { background: #155d9e; }
    .btn-secondary { background: #edf2f7; color: #4a5568; }
    .btn-secondary:hover { background: #e2e8f0; }
    .form-actions { display: flex; gap: .75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; }
</style>
@endpush

@section('content')
<div class="card" style="max-width: 600px;">
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role_id" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
            @error('role_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
