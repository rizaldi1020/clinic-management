@extends('layouts.app')

@section('title', 'Edit Poli')
@section('page-title', 'Edit Poli')
@section('breadcrumb', 'Admin / Departemen / Edit')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="#"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="{{ route('departemen.index') }}" class="active"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="#"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .form-group { display:flex; flex-direction:column; gap:.4rem; margin-bottom:1rem; }
    label { font-size:.875rem; font-weight:500; color:#2d3748; }
    .required::after { content:' *'; color:#e53e3e; }
    input[type="text"], textarea {
        padding:.6rem .85rem; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:.875rem; font-family:inherit; color:#1a202c; outline:none;
        transition:border-color .2s;
    }
    input:focus, textarea:focus { border-color:#1a6db5; box-shadow:0 0 0 3px rgba(26,109,181,.1); }
    .is-invalid { border-color:#fc8181 !important; }
    .invalid-msg { font-size:.8rem; color:#e53e3e; }
    .form-actions { display:flex; gap:.75rem; justify-content:flex-end; margin-top:1.25rem; padding-top:1.25rem; border-top:1px solid #e2e8f0; }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.6rem 1.25rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; }
    .btn-primary { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
</style>
@endpush

@section('content')
<div class="card" style="max-width:560px">
    <form method="POST" action="{{ route('departemen.update', $departemen) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="required">Nama Poli</label>
            <input type="text" name="name" value="{{ old('name', $departemen->name) }}"
                class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
            @error('name')<p class="invalid-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" rows="3">{{ old('description', $departemen->description) }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('departemen.show', $departemen) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
