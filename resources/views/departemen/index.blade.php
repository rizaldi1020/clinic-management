@extends('layouts.app')

@section('title', 'Poli / Departemen')
@section('page-title', 'Poli / Departemen')
@section('breadcrumb', 'Admin / Departemen')

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
    .toolbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:.75rem; }
    .search-form { display:flex; gap:.5rem; }
    .search-form input { padding:.5rem .85rem; border:1.5px solid #e2e8f0; border-radius:8px; font-size:.875rem; font-family:inherit; outline:none; width:240px; }
    .search-form input:focus { border-color:#1a6db5; }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:background .15s; }
    .btn-primary   { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-danger    { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
    .btn-danger:hover { background:#fee2e2; }
    .btn-sm { padding:.35rem .7rem; font-size:.8rem; }

    .dept-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:1rem; }
    .dept-card {
        border:1.5px solid #e2e8f0; border-radius:12px; padding:1.1rem 1.25rem;
        transition:border-color .15s, box-shadow .15s;
    }
    .dept-card:hover { border-color:#bee3f8; box-shadow:0 2px 8px rgba(26,109,181,.1); }
    .dept-card-header { display:flex; align-items:flex-start; justify-content:space-between; gap:.5rem; margin-bottom:.75rem; }
    .dept-icon { width:42px; height:42px; border-radius:10px; background:linear-gradient(135deg,#ebf8ff,#bee3f8); display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0; }
    .dept-name { font-size:.95rem; font-weight:700; color:#1a202c; line-height:1.3; }
    .dept-desc { font-size:.8rem; color:#718096; margin-top:.15rem; line-height:1.4; }
    .dept-stats { display:flex; gap:1rem; margin:0.75rem 0; }
    .stat-item { text-align:center; }
    .stat-item strong { display:block; font-size:1.1rem; font-weight:700; color:#1a202c; }
    .stat-item span { font-size:.72rem; color:#718096; }
    .dept-actions { display:flex; gap:.4rem; padding-top:.75rem; border-top:1px solid #f0f4f8; }

    .alert-error { background:#fff5f5; border:1px solid #feb2b2; border-radius:8px; padding:.75rem 1rem; color:#c53030; font-size:.875rem; margin-bottom:1rem; }
    .empty-state { text-align:center; padding:3rem; color:#a0aec0; }
    .empty-state .icon { font-size:3rem; margin-bottom:.75rem; }
    .pagination-wrap { display:flex; justify-content:space-between; align-items:center; margin-top:1.25rem; font-size:.82rem; color:#718096; }
</style>
@endpush

@section('content')

@if($errors->has('delete'))
    <div class="alert-error">⚠️ {{ $errors->first('delete') }}</div>
@endif

<div class="card">
    <div class="toolbar">
        <form class="search-form" method="GET" action="{{ route('departemen.index') }}">
            <input type="text" name="search" placeholder="Cari nama poli…" value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">🔍 Cari</button>
            @if(request('search'))
                <a href="{{ route('departemen.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
        <a href="{{ route('departemen.create') }}" class="btn btn-primary">+ Tambah Poli</a>
    </div>

    @if($departments->isEmpty())
        <div class="empty-state">
            <div class="icon">🏥</div>
            <p>{{ request('search') ? 'Poli tidak ditemukan.' : 'Belum ada data poli / departemen.' }}</p>
        </div>
    @else
        <div class="dept-grid">
            @foreach($departments as $dept)
            <div class="dept-card">
                <div class="dept-card-header">
                    <div style="display:flex;gap:.75rem;align-items:flex-start">
                        <div class="dept-icon">🏥</div>
                        <div>
                            <div class="dept-name">{{ $dept->name }}</div>
                            <div class="dept-desc">{{ $dept->description ?? 'Tidak ada deskripsi' }}</div>
                        </div>
                    </div>
                </div>
                <div class="dept-stats">
                    <div class="stat-item">
                        <strong>{{ $dept->doctors_count }}</strong>
                        <span>Dokter</span>
                    </div>
                    <div class="stat-item">
                        <strong>{{ $dept->appointments_count }}</strong>
                        <span>Total Kunjungan</span>
                    </div>
                </div>
                <div class="dept-actions">
                    <a href="{{ route('departemen.show', $dept) }}" class="btn btn-secondary btn-sm" style="flex:1;justify-content:center">👁 Detail</a>
                    <a href="{{ route('departemen.edit', $dept) }}" class="btn btn-secondary btn-sm" style="flex:1;justify-content:center">✏️ Edit</a>
                    <form method="POST" action="{{ route('departemen.destroy', $dept) }}"
                          onsubmit="return confirm('Hapus poli {{ $dept->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrap">
            <span>Menampilkan {{ $departments->firstItem() }}–{{ $departments->lastItem() }} dari {{ $departments->total() }} poli</span>
            {{ $departments->links() }}
        </div>
    @endif
</div>
@endsection
