@extends('layouts.app')
@section('title','Dashboard Dokter')
@section('page-title','Dashboard')
@section('breadcrumb','Dokter / Dashboard')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('dokter.dashboard') }}" class="active"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Pasien Saya</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li><a href="{{ route('resep.create') }}"><span class="menu-icon">💊</span> Buat Resep</a></li>
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
    .avatar-sm{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#1a6db5,#2389d8);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;color:#fff;flex-shrink:0}
    .schedule-pills{display:flex;flex-wrap:wrap;gap:.4rem}
    .pill{background:#e6fffa;color:#276749;border-radius:20px;padding:.25rem .75rem;font-size:.78rem;font-weight:600;text-transform:capitalize}
</style>
@endpush

@section('content')

@php
    $doctor        = Auth::user()->doctor;
    $todayApts     = $doctor ? \App\Models\Appointment::with('patient')
                        ->where('doctor_id', $doctor->id)
                        ->whereDate('appointment_date', today())
                        ->orderBy('appointment_time')->get() : collect();
    $totalPasien   = $doctor ? \App\Models\Appointment::where('doctor_id', $doctor->id)->distinct('patient_id')->count('patient_id') : 0;
    $totalSelesai  = $doctor ? \App\Models\Appointment::where('doctor_id', $doctor->id)->where('status','selesai')->count() : 0;
    $bulanIni      = $doctor ? \App\Models\Appointment::where('doctor_id', $doctor->id)->whereMonth('appointment_date', now()->month)->count() : 0;
    $recentRecords = $doctor ? \App\Models\MedicalRecord::with('patient')->where('doctor_id', $doctor->id)->latest('visit_date')->take(6)->get() : collect();
@endphp

@if(!$doctor)
    <div style="background:#fff5f5;border:1px solid #feb2b2;border-radius:8px;padding:1rem;color:#c53030;margin-bottom:1rem">
        ⚠️ Akun Anda belum terhubung ke data dokter. Hubungi administrator.
    </div>
@endif

<div class="stat-grid">
    <div class="stat-card"><div class="stat-icon" style="background:#ebf8ff">📅</div><div class="info"><strong>{{ $todayApts->count() }}</strong><span>Janji Temu Hari Ini</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f0fff4">✅</div><div class="info"><strong>{{ $todayApts->where('status','selesai')->count() }}</strong><span>Selesai Hari Ini</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#e6fffa">👥</div><div class="info"><strong>{{ $totalPasien }}</strong><span>Total Pasien Saya</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fffff0">📊</div><div class="info"><strong>{{ $bulanIni }}</strong><span>Kunjungan Bulan Ini</span></div></div>
</div>

<div class="dash-grid">
    {{-- Jadwal praktik --}}
    <div class="dash-card">
        <div class="dash-card-title">🗓️ Jadwal Praktik Saya</div>
        @if($doctor && $doctor->schedules->isNotEmpty())
            <div class="schedule-pills">
                @foreach($doctor->schedules->sortBy('day_of_week') as $s)
                    <div class="pill">{{ ucfirst($s->day_of_week) }}<br>
                        <span style="font-size:.7rem;font-weight:400">{{ substr($s->start_time,0,5) }}–{{ substr($s->end_time,0,5) }} · {{ $s->quota }} pasien</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="empty-inline">Belum ada jadwal terdaftar.</p>
        @endif
    </div>

    {{-- Antrian hari ini --}}
    <div class="dash-card">
        <div class="dash-card-title">📅 Antrian Hari Ini</div>
        @forelse($todayApts as $apt)
            <div class="row-item">
                <div class="avatar-sm">{{ strtoupper(substr($apt->patient->name,0,1)) }}</div>
                <div style="flex:1">
                    <div style="font-weight:600;color:#1a202c">{{ $apt->patient->name }}</div>
                    <div style="font-size:.78rem;color:#718096">{{ substr($apt->appointment_time,0,5) }} WIB</div>
                </div>
                <span class="badge s-{{ $apt->status }}">{{ ucfirst($apt->status) }}</span>
            </div>
        @empty
            <p class="empty-inline">Tidak ada janji temu hari ini.</p>
        @endforelse
        <a href="{{ route('appointment.index') }}" class="see-all">Lihat semua →</a>
    </div>

    {{-- Rekam medis terakhir --}}
    <div class="dash-card" style="grid-column:1/-1">
        <div class="dash-card-title">📋 Rekam Medis Terakhir</div>
        @forelse($recentRecords as $rm)
            <div class="row-item">
                <div class="avatar-sm">{{ strtoupper(substr($rm->patient->name,0,1)) }}</div>
                <div style="flex:1">
                    <div style="font-weight:600;color:#1a202c">{{ $rm->patient->name }}</div>
                    <div style="font-size:.78rem;color:#718096">{{ \Carbon\Carbon::parse($rm->visit_date)->format('d M Y') }} · {{ Str::limit($rm->diagnosis,50) }}</div>
                </div>
                <a href="{{ route('rekam-medis.show',$rm) }}" style="font-size:.78rem;color:#1a6db5;text-decoration:none">Detail →</a>
            </div>
        @empty
            <p class="empty-inline">Belum ada rekam medis.</p>
        @endforelse
        <a href="{{ route('rekam-medis.index') }}" class="see-all">Lihat semua →</a>
    </div>
</div>
@endsection
