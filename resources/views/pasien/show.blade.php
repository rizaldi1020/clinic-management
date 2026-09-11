@extends('layouts.app')

@section('title', 'Detail Pasien')
@section('page-title', 'Detail Pasien')
@section('breadcrumb', 'Admin / Pasien / Detail')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('admin.users') }}"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="{{ route('departemen.index') }}"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}" class="active"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .profile-header {
        display:flex; align-items:center; gap:1.25rem;
        padding-bottom:1.25rem; margin-bottom:1.25rem;
        border-bottom:1px solid #e2e8f0;
    }
    .profile-avatar {
        width:64px; height:64px; border-radius:16px;
        background:linear-gradient(135deg,#1a6db5,#2389d8);
        display:flex; align-items:center; justify-content:center;
        font-size:1.75rem; font-weight:700; color:#fff; flex-shrink:0;
    }
    .profile-header h3 { font-size:1.15rem; font-weight:700; color:#1a202c; margin-bottom:.2rem; }
    .profile-header p  { font-size:.875rem; color:#718096; }

    .detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .detail-item label { display:block; font-size:.75rem; font-weight:600; color:#a0aec0; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.25rem; }
    .detail-item p { font-size:.9rem; color:#2d3748; }

    .badge { display:inline-block; padding:.2rem .6rem; border-radius:20px; font-size:.78rem; font-weight:600; }
    .badge-blue { background:#ebf8ff; color:#2b6cb0; }
    .badge-pink { background:#fff5f7; color:#c53030; }
    .badge-red  { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }

    .section-title { font-size:.8rem; font-weight:600; color:#718096; text-transform:uppercase; letter-spacing:.07em; margin:1.5rem 0 .75rem; padding-bottom:.5rem; border-bottom:1px solid #e2e8f0; }

    .history-table { width:100%; border-collapse:collapse; font-size:.85rem; }
    .history-table th { padding:.6rem 1rem; text-align:left; font-size:.75rem; font-weight:600; color:#718096; text-transform:uppercase; border-bottom:1px solid #e2e8f0; }
    .history-table td { padding:.6rem 1rem; border-bottom:1px solid #f7fafc; color:#2d3748; }

    .actions { display:flex; gap:.6rem; margin-bottom:1.25rem; }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; }
    .btn-primary   { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-danger    { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
    .btn-danger:hover { background:#fee2e2; }
</style>
@endpush

@section('content')

{{-- Header aksi --}}
<div class="actions">
    <a href="{{ route('pasien.index') }}" class="btn btn-secondary">← Kembali</a>
    <a href="{{ route('pasien.edit', $pasien) }}" class="btn btn-primary">✏️ Edit</a>
    <form method="POST" action="{{ route('pasien.destroy', $pasien) }}"
          onsubmit="return confirm('Hapus pasien ini? Semua data rekam medis terkait ikut terhapus.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑 Hapus</button>
    </form>
</div>

{{-- Kartu profil --}}
<div class="card">
    <div class="profile-header">
        <div class="profile-avatar">{{ strtoupper(substr($pasien->name, 0, 1)) }}</div>
        <div>
            <h3>{{ $pasien->name }}</h3>
            <p>No. RM: <strong>{{ $pasien->no_rm }}</strong> &nbsp;|&nbsp; NIK: {{ $pasien->nik }}</p>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <label>Jenis Kelamin</label>
            <p>
                <span class="badge {{ $pasien->gender === 'L' ? 'badge-blue' : 'badge-pink' }}">
                    {{ $pasien->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
            </p>
        </div>
        <div class="detail-item">
            <label>Golongan Darah</label>
            <p>{{ $pasien->blood_type === '-' ? 'Tidak diketahui' : $pasien->blood_type }}</p>
        </div>
        <div class="detail-item">
            <label>Tempat, Tanggal Lahir</label>
            <p>{{ $pasien->birth_place ?? '—' }}, {{ $pasien->birth_date->format('d F Y') }}</p>
        </div>
        <div class="detail-item">
            <label>Usia</label>
            <p>{{ $pasien->birth_date->age }} tahun</p>
        </div>
        <div class="detail-item">
            <label>No. HP / WhatsApp</label>
            <p>{{ $pasien->phone ?? '—' }}</p>
        </div>
        <div class="detail-item">
            <label>Terdaftar Sejak</label>
            <p>{{ $pasien->created_at->format('d F Y') }}</p>
        </div>
        <div class="detail-item" style="grid-column:1/-1">
            <label>Alamat</label>
            <p>{{ $pasien->address ?? '—' }}</p>
        </div>
        @if($pasien->allergy)
        <div class="detail-item" style="grid-column:1/-1">
            <label>Alergi</label>
            <p><span class="badge badge-red">⚠️ {{ $pasien->allergy }}</span></p>
        </div>
        @endif
    </div>

    {{-- Riwayat Kunjungan --}}
    <p class="section-title">Riwayat Kunjungan ({{ $pasien->appointments->count() }})</p>
    @if($pasien->appointments->isEmpty())
        <p style="color:#a0aec0;font-size:.875rem;">Belum ada kunjungan.</p>
    @else
        <table class="history-table">
            <thead>
                <tr>
                    <th>Tgl Janji</th>
                    <th>Dokter</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pasien->appointments as $apt)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }} {{ $apt->appointment_time }}</td>
                    <td>{{ $apt->doctor->user->name ?? '—' }}</td>
                    <td>{{ Str::limit($apt->complaint, 60) ?? '—' }}</td>
                    <td>
                        @php
                            $colors = ['menunggu'=>'#718096','dikonfirmasi'=>'#2b6cb0','selesai'=>'#276749','dibatalkan'=>'#c53030'];
                            $bg     = ['menunggu'=>'#edf2f7','dikonfirmasi'=>'#ebf8ff','selesai'=>'#f0fff4','dibatalkan'=>'#fff5f5'];
                        @endphp
                        <span class="badge" style="background:{{ $bg[$apt->status] }};color:{{ $colors[$apt->status] }}">
                            {{ ucfirst($apt->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Rekam Medis --}}
    <p class="section-title">Rekam Medis ({{ $pasien->medicalRecords->count() }})</p>
    @if($pasien->medicalRecords->isEmpty())
        <p style="color:#a0aec0;font-size:.875rem;">Belum ada rekam medis.</p>
    @else
        <table class="history-table">
            <thead>
                <tr><th>Tgl Kunjungan</th><th>Dokter</th><th>Diagnosis</th></tr>
            </thead>
            <tbody>
                @foreach($pasien->medicalRecords as $mr)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($mr->visit_date)->format('d/m/Y') }}</td>
                    <td>{{ $mr->doctor->user->name ?? '—' }}</td>
                    <td>{{ Str::limit($mr->diagnosis, 80) ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
