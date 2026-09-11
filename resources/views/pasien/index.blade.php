@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page-title', 'Data Pasien')
@section('breadcrumb', 'Admin / Pasien')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="/admin/users"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="{{ route('departemen.index') }}"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}" class="active"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .toolbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:.75rem; }
    .search-form { display:flex; gap:.5rem; }
    .search-form input {
        padding:.5rem .85rem; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:.875rem; font-family:inherit; outline:none; width:260px;
    }
    .search-form input:focus { border-color:#1a6db5; box-shadow:0 0 0 3px rgba(26,109,181,.1); }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:background .15s; }
    .btn-primary { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-danger { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
    .btn-danger:hover { background:#fee2e2; }
    .btn-sm { padding:.35rem .7rem; font-size:.8rem; }

    table { width:100%; border-collapse:collapse; font-size:.875rem; }
    thead th { padding:.75rem 1rem; text-align:left; font-size:.75rem; font-weight:600; color:#718096; text-transform:uppercase; letter-spacing:.05em; border-bottom:1px solid #e2e8f0; }
    tbody td { padding:.75rem 1rem; border-bottom:1px solid #f7fafc; color:#2d3748; vertical-align:middle; }
    tbody tr:hover { background:#f7fafc; }
    tbody tr:last-child td { border-bottom:none; }

    .badge { display:inline-block; padding:.2rem .55rem; border-radius:20px; font-size:.75rem; font-weight:600; }
    .badge-blue { background:#ebf8ff; color:#2b6cb0; }
    .badge-pink { background:#fff5f7; color:#c53030; }

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
        <form class="search-form" method="GET" action="{{ route('pasien.index') }}">
            <input type="text" name="search" placeholder="Cari nama, No RM, NIK…" value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">🔍 Cari</button>
            @if(request('search'))
                <a href="{{ route('pasien.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
        <a href="{{ route('pasien.create') }}" class="btn btn-primary">+ Tambah Pasien</a>
    </div>

    @if($patients->isEmpty())
        <div class="empty-state">
            <div class="icon">🧑‍🦽</div>
            <p>{{ request('search') ? 'Pasien tidak ditemukan.' : 'Belum ada data pasien.' }}</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. RM</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>JK</th>
                    <th>Tgl Lahir</th>
                    <th>Gol. Darah</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $i => $p)
                <tr>
                    <td>{{ $patients->firstItem() + $i }}</td>
                    <td><strong>{{ $p->no_rm }}</strong></td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->nik }}</td>
                    <td>
                        <span class="badge {{ $p->gender === 'L' ? 'badge-blue' : 'badge-pink' }}">
                            {{ $p->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </td>
                    <td>{{ $p->birth_date->format('d/m/Y') }}</td>
                    <td>{{ $p->blood_type ?? '—' }}</td>
                    <td>{{ $p->phone ?? '—' }}</td>
                    <td>
                        <div style="display:flex;gap:.35rem;">
                            <a href="{{ route('pasien.show', $p) }}" class="btn btn-secondary btn-sm">👁 Detail</a>
                            <a href="{{ route('pasien.edit', $p) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                            <form method="POST" action="{{ route('pasien.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus pasien {{ $p->name }}? Data rekam medis terkait ikut terhapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrap">
            <span>Menampilkan {{ $patients->firstItem() }}–{{ $patients->lastItem() }} dari {{ $patients->total() }} pasien</span>
            {{ $patients->links() }}
        </div>
    @endif
</div>
@endsection
