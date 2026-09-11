@extends('layouts.app')
@section('title', 'Dashboard Pasien')
@section('page-title', 'Dashboard Pasien')
@section('breadcrumb', 'Pasien / Dashboard')
@section('sidebar-menu')
    <li class="menu-label">Menu Pasien</li>
    <li><a href="/pasien" class="active"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li><a href="#"><span class="menu-icon">📅</span> Janji Temu Saya</a></li>
    <li><a href="#"><span class="menu-icon">📋</span> Rekam Medis Saya</a></li>
    <li><a href="#"><span class="menu-icon">🧾</span> Tagihan Saya</a></li>
@endsection
@section('content')
<div class="card">
    <div class="card-title">Selamat datang, {{ Auth::user()->name }}!</div>
    <p style="color:#718096;font-size:.875rem;line-height:1.6">Anda login sebagai <strong>Pasien</strong>. Lihat jadwal dan riwayat kunjungan Anda dari sini.</p>
</div>
@endsection
