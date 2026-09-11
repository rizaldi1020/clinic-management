@extends('layouts.app')
@section('title','Edit Obat')
@section('page-title','Edit Obat')
@section('breadcrumb','Admin / Obat / Edit')
@section('sidebar-menu')
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('obat.index') }}" class="active"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection
@push('styles')
<style>
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
    .form-full{grid-column:1/-1}
    .form-group{display:flex;flex-direction:column;gap:.35rem}
    label{font-size:.875rem;font-weight:500;color:#2d3748}
    .required::after{content:' *';color:#e53e3e}
    input,select,textarea{padding:.6rem .85rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.875rem;font-family:inherit;color:#1a202c;outline:none;transition:border-color .2s}
    input:focus,select:focus,textarea:focus{border-color:#1a6db5;box-shadow:0 0 0 3px rgba(26,109,181,.1)}
    .is-invalid{border-color:#fc8181!important}
    .invalid-msg{font-size:.8rem;color:#e53e3e}
    .form-actions{display:flex;gap:.75rem;justify-content:flex-end;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid #e2e8f0}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.6rem 1.25rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
</style>
@endpush
@section('content')
<div class="card" style="max-width:640px">
    <form method="POST" action="{{ route('obat.update', $obat) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label class="required">Kode Obat</label>
                <input type="text" name="code" value="{{ old('code', $obat->code) }}"
                    class="{{ $errors->has('code') ? 'is-invalid' : '' }}">
                @error('code')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="required">Nama Obat</label>
                <input type="text" name="name" value="{{ old('name', $obat->name) }}"
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                @error('name')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="required">Satuan</label>
                <select name="unit">
                    @foreach(['tablet','kapsul','botol','strip','ampul','sachet','tube','pcs'] as $u)
                        <option value="{{ $u }}" {{ old('unit', $obat->unit) === $u ? 'selected' : '' }}>{{ ucfirst($u) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="required">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $obat->stock) }}" min="0">
            </div>
            <div class="form-group">
                <label class="required">Harga Satuan (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $obat->price) }}" min="0" step="100">
            </div>
            <div class="form-group form-full">
                <label>Deskripsi</label>
                <textarea name="description" rows="2">{{ old('description', $obat->description) }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('obat.show', $obat) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
