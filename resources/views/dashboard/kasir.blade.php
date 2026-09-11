@extends('layouts.app')
@section('title','Dashboard Kasir')
@section('page-title','Dashboard')
@section('breadcrumb','Kasir / Dashboard')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('kasir.dashboard') }}" class="active"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Keuangan</li>
    <li><a href="{{ route('tagihan.index') }}"><span class="menu-icon">🧾</span> Tagihan</a></li>
    <li><a href="{{ route('tagihan.create') }}"><span class="menu-icon">➕</span> Buat Tagihan</a></li>
    <li><a href="{{ route('tagihan.index',['status'=>'belum_dibayar']) }}"><span class="menu-icon">💸</span> Belum Dibayar</a></li>
@endsection

@push('styles')
<style>
    .stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;margin-bottom:1.25rem}
    .stat-card{background:#fff;border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:1rem;box-shadow:0 1px 3px rgba(0,0,0,.07);border:1.5px solid #f0f4f8}
    .stat-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
    .stat-card .info strong{display:block;font-size:1.2rem;font-weight:700;color:#1a202c}
    .stat-card .info span{font-size:.78rem;color:#718096}
    .dash-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
    .dash-card{background:#fff;border-radius:12px;padding:1.1rem 1.5rem;box-shadow:0 1px 3px rgba(0,0,0,.07)}
    .dash-card-title{font-size:.82rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.85rem}
    .row-item{display:flex;align-items:center;gap:.75rem;padding:.6rem 0;border-bottom:1px solid #f7fafc;font-size:.855rem}
    .row-item:last-child{border-bottom:none}
    .badge{display:inline-block;padding:.18rem .55rem;border-radius:20px;font-size:.75rem;font-weight:600}
    .s-belum_dibayar{background:#fff5f5;color:#c53030}
    .s-lunas{background:#f0fff4;color:#276749}
    .s-dibatalkan{background:#edf2f7;color:#718096}
    .empty-inline{color:#a0aec0;font-size:.855rem;padding:.5rem 0}
    .see-all{display:block;text-align:center;margin-top:.75rem;font-size:.82rem;color:#1a6db5;text-decoration:none}
    .inv-code{font-family:monospace;font-size:.78rem;background:#f7fafc;padding:.1rem .4rem;border-radius:4px;color:#4a5568}
    .quick-actions{display:grid;grid-template-columns:1fr 1fr;gap:.65rem;margin-bottom:1.25rem}
    .quick-btn{display:flex;align-items:center;gap:.65rem;background:#fff;border:1.5px solid #e2e8f0;border-radius:10px;padding:.85rem 1rem;text-decoration:none;transition:border-color .15s}
    .quick-btn:hover{border-color:#1a6db5}
    .quick-btn .qicon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0}
    .quick-btn .qlabel{font-size:.855rem;font-weight:600;color:#1a202c}
    .quick-btn .qsub{font-size:.75rem;color:#718096}

    /* Progress bar pendapatan */
    .income-bar-wrap{background:#f0fff4;border-radius:10px;padding:1rem;margin-bottom:1rem}
    .income-label{font-size:.78rem;color:#276749;font-weight:600;margin-bottom:.4rem}
    .income-bar-bg{background:#c6f6d5;border-radius:6px;height:10px;overflow:hidden}
    .income-bar-fill{background:linear-gradient(90deg,#276749,#38a169);height:100%;border-radius:6px;transition:width .5s}
    .income-amount{font-size:1.25rem;font-weight:700;color:#276749;margin-top:.4rem}
</style>
@endpush

@section('content')

@php
    $pendapatanHari   = \App\Models\Bill::where('status','lunas')->whereDate('bill_date', today())->sum('total_amount');
    $pendapatanBulan  = \App\Models\Bill::where('status','lunas')->whereMonth('bill_date', now()->month)->sum('total_amount');
    $tagihanBelum     = \App\Models\Bill::where('status','belum_dibayar')->count();
    $totalPiutang     = \App\Models\Bill::where('status','belum_dibayar')->sum('total_amount');
    $tagihanHariIni   = \App\Models\Bill::whereDate('bill_date', today())->count();
    $recentBills      = \App\Models\Bill::with(['patient','payments'])->latest('bill_date')->take(8)->get();
    $recentPayments   = \App\Models\Payment::with('bill.patient')->latest()->take(6)->get();
    $targetBulan      = 10000000; // target Rp 10 juta/bulan (bisa disesuaikan)
    $pctTarget        = min(($pendapatanBulan/$targetBulan)*100, 100);
@endphp

<div class="stat-grid">
    <div class="stat-card"><div class="stat-icon" style="background:#f0fff4">💰</div><div class="info"><strong>Rp {{ number_format($pendapatanHari,0,',','.') }}</strong><span>Pendapatan Hari Ini</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#ebf8ff">📊</div><div class="info"><strong>Rp {{ number_format($pendapatanBulan,0,',','.') }}</strong><span>Pendapatan Bulan Ini</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fff5f5">🧾</div><div class="info"><strong>{{ $tagihanBelum }}</strong><span>Tagihan Belum Bayar</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fffbeb">💸</div><div class="info"><strong>Rp {{ number_format($totalPiutang,0,',','.') }}</strong><span>Total Piutang</span></div></div>
</div>

{{-- Progress pendapatan bulanan --}}
<div class="income-bar-wrap">
    <div class="income-label">📈 Pendapatan Bulan {{ now()->format('F Y') }}</div>
    <div class="income-bar-bg"><div class="income-bar-fill" style="width:{{ $pctTarget }}%"></div></div>
    <div class="income-amount">Rp {{ number_format($pendapatanBulan,0,',','.') }} <span style="font-size:.82rem;font-weight:400;color:#276749">dari target Rp {{ number_format($targetBulan,0,',','.') }} ({{ round($pctTarget) }}%)</span></div>
</div>

{{-- Aksi cepat --}}
<div class="quick-actions">
    <a href="{{ route('tagihan.create') }}" class="quick-btn">
        <div class="qicon" style="background:#f0fff4">➕</div>
        <div><div class="qlabel">Buat Tagihan Baru</div><div class="qsub">Dari kunjungan selesai</div></div>
    </a>
    <a href="{{ route('tagihan.index',['status'=>'belum_dibayar']) }}" class="quick-btn">
        <div class="qicon" style="background:#fff5f5">💸</div>
        <div><div class="qlabel">Tagihan Belum Dibayar</div><div class="qsub">{{ $tagihanBelum }} tagihan menunggu</div></div>
    </a>
</div>

<div class="dash-grid">
    {{-- Tagihan terbaru --}}
    <div class="dash-card">
        <div class="dash-card-title">🧾 Tagihan Terbaru</div>
        @forelse($recentBills as $b)
            <div class="row-item">
                <div style="flex:1">
                    <div style="font-weight:600;color:#1a202c;font-size:.875rem">{{ $b->patient->name }}</div>
                    <div style="font-size:.75rem;color:#718096"><span class="inv-code">{{ $b->invoice_number }}</span> · {{ \Carbon\Carbon::parse($b->bill_date)->format('d/m/Y') }}</div>
                </div>
                <div style="text-align:right">
                    <div style="font-weight:700;font-size:.875rem;color:#1a202c">Rp {{ number_format($b->total_amount,0,',','.') }}</div>
                    <span class="badge s-{{ $b->status }}">{{ ucfirst(str_replace('_',' ',$b->status)) }}</span>
                </div>
                <a href="{{ route('tagihan.show',$b) }}" style="font-size:.78rem;color:#1a6db5;text-decoration:none;margin-left:.5rem">→</a>
            </div>
        @empty
            <p class="empty-inline">Belum ada tagihan.</p>
        @endforelse
        <a href="{{ route('tagihan.index') }}" class="see-all">Lihat semua →</a>
    </div>

    {{-- Pembayaran terbaru --}}
    <div class="dash-card">
        <div class="dash-card-title">💳 Pembayaran Terbaru</div>
        @forelse($recentPayments as $pay)
            <div class="row-item">
                <div style="flex:1">
                    <div style="font-weight:600;color:#1a202c;font-size:.875rem">{{ $pay->bill->patient->name }}</div>
                    <div style="font-size:.75rem;color:#718096">
                        {{ \Carbon\Carbon::parse($pay->payment_date)->format('d/m/Y H:i') }} ·
                        <span style="background:#ebf8ff;color:#2b6cb0;padding:1px 6px;border-radius:10px;font-size:.7rem;font-weight:600">{{ ucfirst($pay->payment_method) }}</span>
                    </div>
                </div>
                <div style="font-weight:700;font-size:.875rem;color:#276749">+Rp {{ number_format($pay->amount,0,',','.') }}</div>
            </div>
        @empty
            <p class="empty-inline">Belum ada pembayaran.</p>
        @endforelse
    </div>
</div>
@endsection
