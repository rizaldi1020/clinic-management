@extends('layouts.app')

@section('title', 'Janji Temu')
@section('page-title', 'Janji Temu')
@section('breadcrumb', 'Admin / Janji Temu')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li><a href="{{ route('appointment.index') }}" class="active"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}"><span class="menu-icon">🩺</span> Rekam Medis</a></li>
    <li><a href="{{ route('tagihan.index') }}"><span class="menu-icon">💰</span> Pembayaran</a></li>
    
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('user.index') }}"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="{{ route('departemen.index') }}"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .toolbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:.75rem; }
    .search-form { display:flex; gap:.5rem; flex-wrap: wrap; }
    .search-form input, .search-form select {
        padding:.5rem .85rem; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:.875rem; font-family:inherit; outline:none;
    }
    .search-form input[type="text"] { width:200px; }
    .search-form input:focus, .search-form select:focus { border-color:#1a6db5; box-shadow:0 0 0 3px rgba(26,109,181,.1); }
    
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:background .15s; }
    .btn-primary { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-danger { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
    .btn-danger:hover { background:#fee2e2; }
    .btn-success { background:#f0fff4; color:#276749; border:1px solid #9ae6b4; }
    .btn-success:hover { background:#c6f6d5; }
    .btn-sm { padding:.35rem .7rem; font-size:.8rem; }

    table { width:100%; border-collapse:collapse; font-size:.875rem; }
    thead th { padding:.75rem 1rem; text-align:left; font-size:.75rem; font-weight:600; color:#718096; text-transform:uppercase; letter-spacing:.05em; border-bottom:1px solid #e2e8f0; }
    tbody td { padding:.75rem 1rem; border-bottom:1px solid #f7fafc; color:#2d3748; vertical-align:middle; }
    tbody tr:hover { background:#f7fafc; }
    tbody tr:last-child td { border-bottom:none; }

    .badge { display:inline-block; padding:.2rem .55rem; border-radius:20px; font-size:.75rem; font-weight:600; }
    .badge-yellow { background:#fffff0; color:#975a16; border: 1px solid #f6e05e; }
    .badge-blue { background:#ebf8ff; color:#2b6cb0; border: 1px solid #bee3f8; }
    .badge-green { background:#f0fff4; color:#276749; border: 1px solid #c6f6d5; }
    .badge-red { background:#fff5f5; color:#c53030; border: 1px solid #fed7d7; }
    
    .empty-state { text-align:center; padding:3rem; color:#a0aec0; }
    .empty-state .icon { font-size:3rem; margin-bottom:.75rem; }

    .pagination-wrap { display:flex; justify-content:space-between; align-items:center; margin-top:1rem; font-size:.82rem; color:#718096; }
    .pagination-wrap nav { display:flex; gap:.25rem; }
    .pagination-wrap a, .pagination-wrap span {
        padding:.35rem .65rem; border-radius:6px; text-decoration:none;
        border:1px solid #e2e8f0; color:#4a5568;
    }
    .pagination-wrap a:hover { background:#edf2f7; }
    .pagination-wrap .active span { background:#1a6db5; color:#fff; border-color:#1a6db5; }
</style>
@endpush

@section('content')
<div class="card">
    <div class="toolbar">
        <form class="search-form" method="GET" action="{{ route('appointment.index') }}">
            <input type="text" name="search" placeholder="Cari kode, pasien…" value="{{ request('search') }}">
            
            <input type="date" name="date" value="{{ request('date') }}">
            
            <select name="status">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="dikonfirmasi" {{ request('status') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <button type="submit" class="btn btn-secondary">🔍 Cari</button>
            @if(request()->hasAny(['search', 'date', 'status']))
                <a href="{{ route('appointment.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
        @if(auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'resepsionis')
            <a href="{{ route('appointment.create') }}" class="btn btn-primary">+ Janji Temu</a>
        @endif
    </div>

    @if(session('success'))
        <div style="padding:1rem; margin-bottom:1rem; background:#c6f6d5; color:#22543d; border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="padding:1rem; margin-bottom:1rem; background:#fed7d7; color:#9b2c2c; border-radius:8px;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if($appointments->isEmpty())
        <div class="empty-state">
            <div class="icon">📅</div>
            <p>{{ request()->hasAny(['search', 'date', 'status']) ? 'Janji temu tidak ditemukan.' : 'Belum ada data janji temu.' }}</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal & Waktu</th>
                    <th>Pasien</th>
                    <th>Poli & Dokter</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $apt)
                <tr>
                    <td><strong>{{ $apt->appointment_code }}</strong></td>
                    <td>
                        {{ $apt->appointment_date->format('d/m/Y') }}<br>
                        <span style="color:#718096; font-size:.8rem;">🕒 {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}</span>
                    </td>
                    <td>{{ $apt->patient->name }}</td>
                    <td>
                        {{ $apt->department->name }}<br>
                        <span style="color:#718096; font-size:.8rem;">dr. {{ $apt->doctor->user->name }}</span>
                    </td>
                    <td>
                        @if($apt->status === 'menunggu')
                            <span class="badge badge-yellow">Menunggu</span>
                        @elseif($apt->status === 'dikonfirmasi')
                            <span class="badge badge-blue">Dikonfirmasi</span>
                        @elseif($apt->status === 'selesai')
                            <span class="badge badge-green">Selesai</span>
                        @else
                            <span class="badge badge-red">Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.35rem;">
                            <a href="{{ route('appointment.show', $apt) }}" class="btn btn-secondary btn-sm">👁 Detail</a>
                            
                            @if((auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'resepsionis') && $apt->status === 'menunggu')
                                <a href="{{ route('appointment.edit', $apt) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrap">
            <span>Menampilkan {{ $appointments->firstItem() }}–{{ $appointments->lastItem() }} dari {{ $appointments->total() }} data</span>
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
