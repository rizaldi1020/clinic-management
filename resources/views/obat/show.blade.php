@extends('layouts.app')
@section('title','Detail Obat')
@section('page-title','Detail Obat')
@section('breadcrumb','Admin / Obat / Detail')
@section('sidebar-menu')
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('obat.index') }}" class="active"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection
@push('styles')
<style>
    .actions{display:flex;gap:.6rem;margin-bottom:1rem;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
    .btn-danger{background:#fff5f5;color:#c53030;border:1px solid #feb2b2}.btn-danger:hover{background:#fee2e2}
    .btn-success{background:#f0fff4;color:#276749;border:1px solid #9ae6b4}.btn-success:hover{background:#c6f6d5}

    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
    .detail-item label{display:block;font-size:.75rem;font-weight:600;color:#a0aec0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem}
    .detail-item p{font-size:.95rem;color:#1a202c;font-weight:500}

    .stock-display{font-size:2rem;font-weight:700}
    .stock-aman{color:#276749}
    .stock-rendah{color:#b7791f}
    .stock-habis{color:#c53030}

    .stock-section{border:1.5px solid #e2e8f0;border-radius:10px;padding:1rem;margin-top:1rem}
    .stock-section h4{font-size:.8rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem}
    .stock-form{display:flex;gap:.5rem;align-items:center;flex-wrap:wrap}
    .stock-form select,.stock-form input{padding:.5rem .75rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.875rem;font-family:inherit;outline:none}
    .stock-form select:focus,.stock-form input:focus{border-color:#1a6db5}
    .stock-form input{width:100px}
    .alert-error{background:#fff5f5;border:1px solid #feb2b2;border-radius:8px;padding:.75rem 1rem;color:#c53030;font-size:.875rem;margin-bottom:1rem}
    .section-title{font-size:.8rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.07em;margin:1.5rem 0 .75rem;padding-bottom:.5rem;border-bottom:1px solid #e2e8f0}
</style>
@endpush
@section('content')

@if($errors->has('delete') || $errors->has('stock'))
    <div class="alert-error">⚠️ {{ $errors->first('delete') ?? $errors->first('stock') }}</div>
@endif

<div class="actions">
    <a href="{{ route('obat.index') }}" class="btn btn-secondary">← Kembali</a>
    <a href="{{ route('obat.edit', $obat) }}" class="btn btn-primary">✏️ Edit</a>
    <form method="POST" action="{{ route('obat.destroy', $obat) }}"
          onsubmit="return confirm('Hapus obat {{ addslashes($obat->name) }}?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑 Hapus</button>
    </form>
</div>

<div class="card">
    <div class="detail-grid">
        <div class="detail-item">
            <label>Kode Obat</label>
            <p style="font-family:monospace;font-size:.95rem">{{ $obat->code }}</p>
        </div>
        <div class="detail-item">
            <label>Nama Obat</label>
            <p>{{ $obat->name }}</p>
        </div>
        <div class="detail-item">
            <label>Satuan</label>
            <p>{{ ucfirst($obat->unit) }}</p>
        </div>
        <div class="detail-item">
            <label>Harga Satuan</label>
            <p>Rp {{ number_format($obat->price, 0, ',', '.') }}</p>
        </div>
        <div class="detail-item" style="grid-column:1/-1">
            <label>Deskripsi</label>
            <p style="font-weight:400;color:#4a5568">{{ $obat->description ?? '—' }}</p>
        </div>
    </div>

    {{-- Stok --}}
    @php
        $stockClass = $obat->stock === 0 ? 'stock-habis' : ($obat->stock <= 10 ? 'stock-rendah' : 'stock-aman');
        $stockLabel = $obat->stock === 0 ? '🚫 Habis' : ($obat->stock <= 10 ? '⚠️ Rendah' : '✓ Aman');
    @endphp

    <div class="section-title">Stok Saat Ini</div>
    <div style="display:flex;align-items:baseline;gap:.75rem;margin-bottom:.5rem">
        <span class="stock-display {{ $stockClass }}">{{ $obat->stock }}</span>
        <span style="font-size:.9rem;color:#718096">{{ ucfirst($obat->unit) }} &nbsp;·&nbsp; {{ $stockLabel }}</span>
    </div>

    {{-- Form update stok --}}
    <div class="stock-section">
        <h4>Update Stok Manual</h4>
        <form class="stock-form" method="POST" action="{{ route('obat.update-stock', $obat) }}">
            @csrf @method('PATCH')
            <select name="action">
                <option value="tambah">+ Tambah Stok</option>
                <option value="kurangi">− Kurangi Stok</option>
            </select>
            <input type="number" name="jumlah" value="1" min="1" placeholder="Jumlah">
            <span style="font-size:.875rem;color:#718096">{{ ucfirst($obat->unit) }}</span>
            <button type="submit" class="btn btn-success">💾 Update</button>
        </form>
    </div>
</div>
@endsection
