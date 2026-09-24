@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('breadcrumb', 'Admin / Manajemen User')

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
    .toolbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:.75rem; }
    .search-form { display:flex; gap:.5rem; }
    .search-form input, .search-form select {
        padding:.5rem .85rem; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:.875rem; font-family:inherit; outline:none;
    }
    .search-form input { width:200px; }
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
    .badge-green { background:#c6f6d5; color:#22543d; }
    .badge-gray { background:#edf2f7; color:#4a5568; }
    
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
        <form class="search-form" method="GET" action="{{ route('user.index') }}">
            <input type="text" name="search" placeholder="Cari nama, email, no HP…" value="{{ request('search') }}">
            
            <select name="role">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>

            <select name="status">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit" class="btn btn-secondary">🔍 Cari</button>
            @if(request('search') || request('role') || request('status'))
                <a href="{{ route('user.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
        <a href="{{ route('user.create') }}" class="btn btn-primary">+ Tambah User</a>
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

    @if($users->isEmpty())
        <div class="empty-state">
            <div class="icon">👥</div>
            <p>{{ request()->hasAny(['search', 'role', 'status']) ? 'User tidak ditemukan.' : 'Belum ada data user.' }}</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $i => $u)
                <tr>
                    <td>{{ $users->firstItem() + $i }}</td>
                    <td><strong>{{ $u->name }}</strong></td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->phone ?? '—' }}</td>
                    <td>{{ ucfirst($u->role->name) }}</td>
                    <td>
                        <span class="badge {{ $u->is_active ? 'badge-green' : 'badge-gray' }}">
                            {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.35rem;">
                            <a href="{{ route('user.show', $u) }}" class="btn btn-secondary btn-sm">👁 Detail</a>
                            <a href="{{ route('user.edit', $u) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                            
                            @if(auth()->id() !== $u->id)
                                <form method="POST" action="{{ route('user.toggle-status', $u) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn {{ $u->is_active ? 'btn-danger' : 'btn-success' }} btn-sm"
                                            onclick="return confirm('Yakin ingin {{ $u->is_active ? 'menonaktifkan' : 'mengaktifkan' }} user ini?')">
                                        {{ $u->is_active ? '🛑 Nonaktif' : '✅ Aktif' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('user.destroy', $u) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus user {{ $u->name }} secara permanen?')">
                                        🗑 Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrap">
            <span>Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user</span>
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
