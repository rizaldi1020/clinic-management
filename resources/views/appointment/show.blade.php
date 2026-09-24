@extends('layouts.app')

@section('title', 'Detail Janji Temu')
@section('page-title', 'Detail Janji Temu')
@section('breadcrumb', 'Admin / Janji Temu / Detail')

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
    .detail-grid { display: grid; grid-template-columns: 180px 1fr; gap: 1rem; margin-bottom: 1rem; border-bottom: 1px solid #f7fafc; padding-bottom: 1rem; }
    .detail-grid:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .detail-label { font-weight: 600; color: #4a5568; }
    .detail-value { color: #2d3748; }
    
    .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .5rem 1rem; border-radius: 8px; font-size: .875rem; font-family: inherit; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: background .15s; }
    .btn-secondary { background: #edf2f7; color: #4a5568; }
    .btn-secondary:hover { background: #e2e8f0; }
    .btn-primary { background: #1a6db5; color: #fff; }
    .btn-primary:hover { background: #155d9e; }
    .btn-danger { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
    .btn-danger:hover { background: #fee2e2; }
    
    .badge { display:inline-block; padding:.2rem .55rem; border-radius:20px; font-size:.75rem; font-weight:600; }
    .badge-yellow { background:#fffff0; color:#975a16; border: 1px solid #f6e05e; }
    .badge-blue { background:#ebf8ff; color:#2b6cb0; border: 1px solid #bee3f8; }
    .badge-green { background:#f0fff4; color:#276749; border: 1px solid #c6f6d5; }
    .badge-red { background:#fff5f5; color:#c53030; border: 1px solid #fed7d7; }
</style>
@endpush

@section('content')
<div class="card" style="max-width: 800px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="margin: 0; font-size: 1.25rem; color: #2d3748;">Informasi Janji Temu</h3>
        <div>
            @if((auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'resepsionis') && $appointment->status === 'menunggu')
                <a href="{{ route('appointment.edit', $appointment) }}" class="btn btn-primary">✏️ Edit</a>
            @endif
            <a href="{{ route('appointment.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
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

    <div class="detail-grid">
        <div class="detail-label">Kode Janji Temu</div>
        <div class="detail-value"><strong>{{ $appointment->appointment_code }}</strong></div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Status</div>
        <div class="detail-value">
            @if($appointment->status === 'menunggu')
                <span class="badge badge-yellow">Menunggu</span>
            @elseif($appointment->status === 'dikonfirmasi')
                <span class="badge badge-blue">Dikonfirmasi</span>
            @elseif($appointment->status === 'selesai')
                <span class="badge badge-green">Selesai</span>
            @else
                <span class="badge badge-red">Dibatalkan</span>
            @endif
        </div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Pasien</div>
        <div class="detail-value">
            <a href="{{ route('pasien.show', $appointment->patient) }}" style="color: #1a6db5; text-decoration: none;">
                {{ $appointment->patient->name }} ({{ $appointment->patient->no_rm }})
            </a>
        </div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Poli & Dokter</div>
        <div class="detail-value">
            {{ $appointment->department->name }}<br>
            <span style="color: #718096; font-size: 0.9em;">dr. {{ $appointment->doctor->user->name }}</span>
        </div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Tanggal & Waktu</div>
        <div class="detail-value">
            {{ $appointment->appointment_date->format('l, d F Y') }}<br>
            <span style="color: #718096; font-size: 0.9em;">Jam {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</span>
        </div>
    </div>
    <div class="detail-grid">
        <div class="detail-label">Keluhan Awal</div>
        <div class="detail-value">{{ $appointment->complaint ?: '-' }}</div>
    </div>

    @if(auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'resepsionis' || auth()->user()->role->name === 'dokter')
    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;">
        <h4 style="margin: 0 0 1rem 0; font-size: 1rem; color: #4a5568;">Tindakan</h4>
        
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            @if($appointment->status === 'menunggu')
                <form method="POST" action="{{ route('appointment.update-status', $appointment) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="dikonfirmasi">
                    <button type="submit" class="btn btn-primary" style="background: #2b6cb0;" onclick="return confirm('Konfirmasi janji temu ini?')">
                        ✅ Konfirmasi Kedatangan
                    </button>
                </form>
            @endif

            @if($appointment->status !== 'selesai' && $appointment->status !== 'dibatalkan')
                <form method="POST" action="{{ route('appointment.update-status', $appointment) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="dibatalkan">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Batalkan janji temu ini?')">
                        ❌ Batalkan Janji
                    </button>
                </form>
            @endif

            @if(auth()->user()->role->name === 'dokter' && $appointment->status === 'dikonfirmasi')
                @if(!$appointment->medicalRecord)
                    <a href="{{ route('rekam-medis.create', ['appointment_id' => $appointment->id]) }}" class="btn btn-primary" style="background: #276749;">
                        🩺 Mulai Pemeriksaan
                    </a>
                @else
                    <a href="{{ route('rekam-medis.show', $appointment->medicalRecord) }}" class="btn btn-secondary">
                        📄 Lihat Rekam Medis
                    </a>
                @endif
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
