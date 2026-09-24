@extends('layouts.app')

@section('title', 'Detail User')
@section('page-title', 'Detail User')
@section('breadcrumb', 'Admin / Manajemen User / Detail')

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
    .detail-grid { display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 1rem; border-bottom: 1px solid #f7fafc; padding-bottom: 1rem; }
    .detail-grid:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .detail-label { font-weight: 600; color: #4a5568; }
    .detail-value { color: #2d3748; }
    
    .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .5rem 1rem; border-radius: 8px; font-size: .875rem; font-family: inherit; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: background .15s; }
    .btn-secondary { background: #edf2f7; color: #4a5568; }
    .btn-secondary:hover { background: #e2e8f0; }
    .btn-primary { background: #1a6db5; color: #fff; }
    .btn-primary:hover { background: #155d9e; }
    
    .badge { display:inline-block; padding:.2rem .55rem; border-radius:20px; font-size:.75rem; font-weight:600; }
    .badge-green { background:#c6f6d5; color:#22543d; }
    .badge-gray { background:#edf2f7; color:#4a5568; }
</style>
@endpush

@section('content')
<div class="card" style="max-width: 600px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="margin: 0; font-size: 1.25rem; color: #2d3748;">Informasi User</h3>
        <div>
            <a href="{{ route('user.edit', $user) }}" class="btn btn-primary">✏️ Edit</a>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    
    @if(session('success'))
        <div style="padding:1rem; margin-bottom:1rem; background:#c6f6d5; color:#22543d; border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="detail-grid">
        <div class="detail-label">Nama Lengkap</div>
        <div class="detail-value">{{ $user->name }}</div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Email</div>
        <div class="detail-value">{{ $user->email }}</div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Role</div>
        <div class="detail-value">{{ ucfirst($user->role->name) }}</div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">No. HP</div>
        <div class="detail-value">{{ $user->phone ?? '-' }}</div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Alamat</div>
        <div class="detail-value">{{ $user->address ?? '-' }}</div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Status</div>
        <div class="detail-value">
            <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-gray' }}">
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Dibuat Pada</div>
        <div class="detail-value">{{ $user->created_at->format('d/m/Y H:i') }}</div>
    </div>

    @if(auth()->id() !== $user->id)
    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;">
        <h4 style="margin: 0 0 1rem 0; font-size: 1rem; color: #4a5568;">Tindakan Tambahan</h4>
        <form method="POST" action="{{ route('user.reset-password', $user) }}">
            @csrf
            <button type="submit" class="btn btn-secondary" onclick="return confirm('Reset password user ini ke \'password\'?')">
                🔑 Reset Password
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
