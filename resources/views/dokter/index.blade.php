@extends('layouts.app')

@section('title', 'Data Dokter')
@section('page-title', 'Data Dokter')
@section('breadcrumb', 'Admin / Dokter')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="#"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="#"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}" class="active"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="#"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .toolbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:.75rem; }
    .filter-row { display:flex; gap:.5rem; flex-wrap:wrap; }
    .filter-row input, .filter-row select {
        padding:.5rem .85rem; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:.875rem; font-family:inherit; outline:none;
    }
    .filter-row input { width:240px; }
    .filter-row input:focus, .filter-row select:focus { border-color:#1a6db5; }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:background .15s; }
    .btn-primary   { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-danger    { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
    .btn-danger:hover { background:#fee2e2; }
    .btn-sm { padding:.35rem .7rem; font-size:.8rem; }

    .doctor-card {
        display:grid; grid-template-columns:auto 1fr auto;
        align-items:center; gap:1rem;
        padding:.85rem 1rem; border-bottom:1px solid #f7fafc;
    }
    .doctor-card:last-child { border-bottom:none; }
    .doctor-card:hover { background:#fafbfd; }
    .avatar {
        width:44px; height:44px; border-radius:12px;
        background:linear-gradient(135deg,#1a6db5,#2389d8);
        display:flex; align-items:center; justify-content:center;
        font-size:1.1rem; font-weight:700; color:#fff; flex-shrink:0;
    }
    .doc-name { font-weight:600; font-size:.9rem; color:#1a202c; }
    .doc-meta { font-size:.8rem; color:#718096; margin-top:.15rem; }
    .badge { display:inline-block; padding:.15rem .5rem; border-radius:20px; font-size:.75rem; font-weight:600; }
    .badge-teal { background:#e6fffa; color:#276749; }
    .doc-actions { display:flex; gap:.35rem; }

    .empty-state { text-align:center; padding:3rem; color:#a0aec0; }
    .empty-state .icon { font-size:3rem; margin-bottom:.75rem; }

    .pagination-wrap { display:flex; justify-content:space-between; align-items:center; margin-top:1rem; font-size:.82rem; color:#718096; }
</style>
@endpush

@section('content')
<div class="card">
    <div class="toolbar">
        <form class="filter-row" method="GET" action="{{ route('dokter.index') }}">
            <input type="text" name="search" placeholder="Cari nama, spesialisasi, No. STR…" value="{{ request('search') }}">
            <select name="department">
                <option value="">Semua Poli</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            @if(request()->anyFilled(['search','department']))
                <a href="{{ route('dokter.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
        <a href="{{ route('dokter.create') }}" class="btn btn-primary">+ Tambah Dokter</a>
    </div>

    @if($doctors->isEmpty())
        <div class="empty-state">
            <div class="icon">👨‍⚕️</div>
            <p>{{ request()->anyFilled(['search','department']) ? 'Dokter tidak ditemukan.' : 'Belum ada data dokter.' }}</p>
        </div>
    @else
        @foreach($doctors as $d)
        <div class="doctor-card">
            <div class="avatar">{{ strtoupper(substr($d->user->name, 0, 1)) }}</div>
            <div>
                <div class="doc-name">{{ $d->user->name }}</div>
                <div class="doc-meta">
                    <span class="badge badge-teal">{{ $d->department->name }}</span>
                    &nbsp;{{ $d->specialization ?? 'Umum' }}
                    &nbsp;·&nbsp; STR/SIP: {{ $d->license_number }}
                    &nbsp;·&nbsp; Rp {{ number_format($d->consultation_fee, 0, ',', '.') }}
                </div>
            </div>
            <div class="doc-actions">
                <a href="{{ route('dokter.show', $d) }}" class="btn btn-secondary btn-sm">👁 Detail</a>
                <a href="{{ route('dokter.edit', $d) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                <form method="POST" action="{{ route('dokter.destroy', $d) }}"
                      onsubmit="return confirm('Hapus dr. {{ $d->user->name }}? Akun login dokter ini juga akan terhapus.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                </form>
            </div>
        </div>
        @endforeach

        <div class="pagination-wrap">
            <span>Menampilkan {{ $doctors->firstItem() }}–{{ $doctors->lastItem() }} dari {{ $doctors->total() }} dokter</span>
            {{ $doctors->links() }}
        </div>
    @endif
</div>
@endsection
