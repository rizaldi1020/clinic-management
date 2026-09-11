@extends('layouts.app')
@section('title','Dashboard Resepsionis')
@section('page-title','Dashboard')
@section('breadcrumb','Resepsionis / Dashboard')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('resepsionis.dashboard') }}" class="active"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Layanan</li>
    <li><a href="{{ route('pasien.create') }}"><span class="menu-icon">📝</span> Daftarkan Pasien</a></li>
    <li><a href="{{ route('appointment.create') }}"><span class="menu-icon">📅</span> Buat Janji Temu</a></li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📋</span> Daftar Janji Temu</a></li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
@endsection

@push('styles')
<style>
    .stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1rem;margin-bottom:1.25rem}
    .stat-card{background:#fff;border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:1rem;box-shadow:0 1px 3px rgba(0,0,0,.07);border:1.5px solid #f0f4f8}
    .stat-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
    .stat-card .info strong{display:block;font-size:1.35rem;font-weight:700;color:#1a202c}
    .stat-card .info span{font-size:.78rem;color:#718096}
    .dash-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
    .dash-card{background:#fff;border-radius:12px;padding:1.1rem 1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.07)}
    .dash-card-title{font-size:.82rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.85rem}
    .row-item{display:flex;align-items:center;gap:.75rem;padding:.55rem 0;border-bottom:1px solid #f7fafc;font-size:.855rem}
    .row-item:last-child{border-bottom:none}
    .badge{display:inline-block;padding:.15rem .5rem;border-radius:20px;font-size:.72rem;font-weight:600}
    .s-menunggu{background:#edf2f7;color:#4a5568}
    .s-dikonfirmasi{background:#ebf8ff;color:#2b6cb0}
    .s-selesai{background:#f0fff4;color:#276749}
    .s-dibatalkan{background:#fff5f5;color:#c53030}
    .empty-inline{color:#a0aec0;font-size:.855rem;padding:.5rem 0}
    .see-all{display:block;text-align:center;margin-top:.75rem;font-size:.82rem;color:#1a6db5;text-decoration:none}
    .avatar-sm{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#553c9a,#805ad5);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;color:#fff;flex-shrink:0}
    .quick-actions{display:grid;grid-template-columns:1fr 1fr;gap:.65rem;margin-bottom:1.25rem}
    .quick-btn{display:flex;align-items:center;gap:.65rem;background:#fff;border:1.5px solid #e2e8f0;border-radius:10px;padding:.85rem 1rem;text-decoration:none;transition:border-color .15s,box-shadow .15s}
    .quick-btn:hover{border-color:#1a6db5;box-shadow:0 2px 8px rgba(26,109,181,.1)}
    .quick-btn .qicon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0}
    .quick-btn .qlabel{font-size:.855rem;font-weight:600;color:#1a202c}
    .quick-btn .qsub{font-size:.75rem;color:#718096}
</style>
@endpush

@section('content')

@php
    $aptHariIni    = \App\Models\Appointment::whereDate('appointment_date', today())->count();
    $menunggu      = \App\Models\Appointment::whereDate('appointment_date', today())->where('status','menunggu')->count();
    $pasienBaru    = \App\Models\Patient::whereDate('created_at', today())->count();
    $totalPasien   = \App\Models\Patient::count();
    $todayApts     = \App\Models\Appointment::with(['patient','doctor.user','department'])
                        ->whereDate('appointment_date', today())
                        ->orderBy('appointment_time')->take(10)->get();
    $recentPasien  = \App\Models\Patient::latest()->take(5)->get();
@endphp

<div class="stat-grid">
    <div class="stat-card"><div class="stat-icon" style="background:#ebf8ff">📅</div><div class="info"><strong>{{ $aptHariIni }}</strong><span>Janji Temu Hari Ini</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fffbeb">⏳</div><div class="info"><strong>{{ $menunggu }}</strong><span>Masih Menunggu</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f0fff4">🆕</div><div class="info"><strong>{{ $pasienBaru }}</strong><span>Pasien Baru Hari Ini</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#faf5ff">👥</div><div class="info"><strong>{{ $totalPasien }}</strong><span>Total Pasien Terdaftar</span></div></div>
</div>

{{-- Aksi cepat --}}
<div class="quick-actions">
    <a href="{{ route('pasien.create') }}" class="quick-btn">
        <div class="qicon" style="background:#f0fff4">📝</div>
        <div><div class="qlabel">Daftarkan Pasien Baru</div><div class="qsub">Isi data pasien baru</div></div>
    </a>
    <a href="{{ route('appointment.create') }}" class="quick-btn">
        <div class="qicon" style="background:#ebf8ff">📅</div>
        <div><div class="qlabel">Buat Janji Temu</div><div class="qsub">Jadwalkan kunjungan pasien</div></div>
    </a>
    <a href="{{ route('pasien.index') }}" class="quick-btn">
        <div class="qicon" style="background:#faf5ff">🔍</div>
        <div><div class="qlabel">Cari Data Pasien</div><div class="qsub">Cari by nama, No. RM, NIK</div></div>
    </a>
    <a href="{{ route('appointment.index') }}" class="quick-btn">
        <div class="qicon" style="background:#fffbeb">📋</div>
        <div><div class="qlabel">Semua Janji Temu</div><div class="qsub">Lihat & kelola antrian</div></div>
    </a>
</div>

<div class="dash-grid">
    {{-- Antrian hari ini --}}
    <div class="dash-card">
        <div class="dash-card-title">📅 Antrian Hari Ini</div>
        @forelse($todayApts as $apt)
            <div class="row-item">
                <div class="avatar-sm">{{ strtoupper(substr($apt->patient->name,0,1)) }}</div>
                <div style="flex:1">
                    <div style="font-weight:600;color:#1a202c">{{ $apt->patient->name }}</div>
                    <div style="font-size:.78rem;color:#718096">{{ substr($apt->appointment_time,0,5) }} · {{ $apt->doctor->user->name }}</div>
                </div>
                <span class="badge s-{{ $apt->status }}">{{ ucfirst($apt->status) }}</span>
            </div>
        @empty
            <p class="empty-inline">Tidak ada janji temu hari ini.</p>
        @endforelse
        <a href="{{ route('appointment.index') }}" class="see-all">Lihat semua →</a>
    </div>

    {{-- Pasien terbaru --}}
    <div class="dash-card">
        <div class="dash-card-title">🆕 Pasien Terbaru Terdaftar</div>
        @forelse($recentPasien as $p)
            <div class="row-item">
                <div class="avatar-sm">{{ strtoupper(substr($p->name,0,1)) }}</div>
                <div style="flex:1">
                    <div style="font-weight:600;color:#1a202c">{{ $p->name }}</div>
                    <div style="font-size:.78rem;color:#718096">{{ $p->no_rm }} · {{ $p->created_at->diffForHumans() }}</div>
                </div>
                <a href="{{ route('pasien.show',$p) }}" style="font-size:.78rem;color:#1a6db5;text-decoration:none">Detail →</a>
            </div>
        @empty
            <p class="empty-inline">Belum ada pasien terdaftar.</p>
        @endforelse
        <a href="{{ route('pasien.index') }}" class="see-all">Lihat semua →</a>
    </div>
</div>
@endsection
