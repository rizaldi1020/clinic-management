@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Admin / Dashboard')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="/admin.dashboard" class="active"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="#"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="/departemen"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="/dokter"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="/pasien"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="/obat"><span class="menu-icon">💊</span> Data Obat</a></li>
    <li class="menu-label">Laporan</li>
    <li><a href="/laporan/kunjungan"><span class="menu-icon">📊</span> Laporan Kunjungan</a></li>
    <li><a href="/laporan/keuangan"><span class="menu-icon">💰</span> Laporan Keuangan</a></li>
@endsection

@section('content')
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#ebf8ff">👥</div>
        <div class="info"><strong>—</strong><span>Total Pasien</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fff4">👨‍⚕️</div>
        <div class="info"><strong>—</strong><span>Total Dokter</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fffff0">📅</div>
        <div class="info"><strong>—</strong><span>Janji Hari Ini</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff5f5">💰</div>
        <div class="info"><strong>—</strong><span>Pendapatan Hari Ini</span></div>
    </div>
</div>

<div class="card">
    <div class="card-title">Selamat datang, {{ Auth::user()->name }}!</div>
    <p style="color:#718096;font-size:.875rem;line-height:1.6">
        Anda login sebagai <strong>Administrator</strong>. Gunakan menu di sebelah kiri untuk mengelola data klinik.
    </p>
</div>
@endsection
