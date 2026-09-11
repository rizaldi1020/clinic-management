@extends('layouts.app')

@section('title', 'Detail Poli')
@section('page-title', 'Detail Poli')
@section('breadcrumb', 'Admin / Departemen / Detail')

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
    .actions { display:flex; gap:.6rem; margin-bottom:1rem; }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; }
    .btn-primary   { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-danger    { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
    .btn-danger:hover { background:#fee2e2; }

    .poli-header { display:flex; align-items:center; gap:1rem; padding-bottom:1.25rem; margin-bottom:1.25rem; border-bottom:1px solid #e2e8f0; }
    .poli-icon { width:56px; height:56px; border-radius:14px; background:linear-gradient(135deg,#ebf8ff,#bee3f8); display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0; }
    .poli-header h3 { font-size:1.15rem; font-weight:700; color:#1a202c; margin-bottom:.2rem; }
    .poli-header p  { font-size:.875rem; color:#718096; }

    .stats-row { display:flex; gap:1.5rem; margin-bottom:1.5rem; }
    .stat-box { background:#f7fafc; border-radius:10px; padding:.85rem 1.25rem; text-align:center; min-width:100px; }
    .stat-box strong { display:block; font-size:1.5rem; font-weight:700; color:#1a202c; }
    .stat-box span { font-size:.78rem; color:#718096; }

    .section-title { font-size:.8rem; font-weight:600; color:#718096; text-transform:uppercase; letter-spacing:.07em; margin:1.25rem 0 .75rem; padding-bottom:.5rem; border-bottom:1px solid #e2e8f0; }

    .doctor-row { display:flex; align-items:center; gap:.85rem; padding:.75rem 0; border-bottom:1px solid #f7fafc; }
    .doctor-row:last-child { border-bottom:none; }
    .doc-avatar { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,#1a6db5,#2389d8); display:flex; align-items:center; justify-content:center; font-size:.95rem; font-weight:700; color:#fff; flex-shrink:0; }
    .doc-name { font-weight:600; font-size:.88rem; color:#1a202c; }
    .doc-sub  { font-size:.78rem; color:#718096; }
    .badge { display:inline-block; padding:.15rem .5rem; border-radius:20px; font-size:.72rem; font-weight:600; }
    .badge-blue { background:#ebf8ff; color:#2b6cb0; }

    .jadwal-pills { display:flex; flex-wrap:wrap; gap:.35rem; margin-top:.3rem; }
    .jadwal-pill { background:#e6fffa; color:#276749; border-radius:20px; padding:.15rem .55rem; font-size:.72rem; font-weight:600; text-transform:capitalize; }

    .empty-inline { color:#a0aec0; font-size:.875rem; padding:.5rem 0; }

    .alert-error { background:#fff5f5; border:1px solid #feb2b2; border-radius:8px; padding:.75rem 1rem; color:#c53030; font-size:.875rem; margin-bottom:1rem; }
</style>
@endpush

@section('content')

@if($errors->has('delete'))
    <div class="alert-error">⚠️ {{ $errors->first('delete') }}</div>
@endif

<div class="actions">
    <a href="{{ route('departemen.index') }}" class="btn btn-secondary">← Kembali</a>
    <a href="{{ route('departemen.edit', $departemen) }}" class="btn btn-primary">✏️ Edit</a>
    <form method="POST" action="{{ route('departemen.destroy', $departemen) }}"
          onsubmit="return confirm('Hapus poli {{ $departemen->name }}?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑 Hapus</button>
    </form>
</div>

<div class="card">
    {{-- Header Poli --}}
    <div class="poli-header">
        <div class="poli-icon">🏥</div>
        <div>
            <h3>{{ $departemen->name }}</h3>
            <p>{{ $departemen->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="stats-row">
        <div class="stat-box">
            <strong>{{ $departemen->doctors->count() }}</strong>
            <span>Dokter</span>
        </div>
        <div class="stat-box">
            <strong>{{ $departemen->doctors->sum(fn($d) => $d->schedules->count()) }}</strong>
            <span>Jadwal Aktif</span>
        </div>
        <div class="stat-box">
            <strong>{{ $departemen->created_at->format('Y') }}</strong>
            <span>Tahun Berdiri</span>
        </div>
    </div>

    {{-- Daftar Dokter --}}
    <p class="section-title">Dokter di Poli Ini ({{ $departemen->doctors->count() }})</p>

    @if($departemen->doctors->isEmpty())
        <p class="empty-inline">Belum ada dokter terdaftar di poli ini.
            <a href="{{ route('dokter.create') }}" style="color:#1a6db5;">Tambah dokter →</a>
        </p>
    @else
        @foreach($departemen->doctors as $doc)
        <div class="doctor-row">
            <div class="doc-avatar">{{ strtoupper(substr($doc->user->name, 0, 1)) }}</div>
            <div style="flex:1">
                <div class="doc-name">{{ $doc->user->name }}</div>
                <div class="doc-sub">
                    {{ $doc->specialization ?? 'Umum' }} &nbsp;·&nbsp;
                    STR/SIP: {{ $doc->license_number }} &nbsp;·&nbsp;
                    Rp {{ number_format($doc->consultation_fee, 0, ',', '.') }}
                </div>
                @if($doc->schedules->isNotEmpty())
                    <div class="jadwal-pills">
                        @foreach($doc->schedules->sortBy('day_of_week') as $s)
                            <span class="jadwal-pill">{{ $s->day_of_week }} {{ substr($s->start_time,0,5) }}–{{ substr($s->end_time,0,5) }}</span>
                        @endforeach
                    </div>
                @else
                    <div style="font-size:.75rem;color:#cbd5e0;margin-top:.2rem;">Belum ada jadwal</div>
                @endif
            </div>
            <a href="{{ route('dokter.show', $doc) }}" class="btn btn-secondary" style="font-size:.8rem;padding:.35rem .7rem;">Detail →</a>
        </div>
        @endforeach
    @endif
</div>
@endsection
