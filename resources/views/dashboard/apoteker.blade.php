@extends('layouts.app')
@section('title','Dashboard Apoteker')
@section('page-title','Dashboard')
@section('breadcrumb','Apoteker / Dashboard')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('apoteker.dashboard') }}" class="active"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Farmasi</li>
    <li><a href="/obat/index"><span class="menu-icon">💊</span> Data Obat</a></li>
    <li><a href="/rekam-medis/index"><span class="menu-icon">📋</span> Resep Masuk</a></li>
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
    .row-item{display:flex;align-items:center;justify-content:space-between;padding:.55rem 0;border-bottom:1px solid #f7fafc;font-size:.855rem}
    .row-item:last-child{border-bottom:none}
    .empty-inline{color:#a0aec0;font-size:.855rem;padding:.5rem 0}
    .see-all{display:block;text-align:center;margin-top:.75rem;font-size:.82rem;color:#1a6db5;text-decoration:none}
    .stock-bar-wrap{flex:1;margin:0 .75rem;height:8px;background:#edf2f7;border-radius:4px;overflow:hidden}
    .stock-bar{height:100%;border-radius:4px}
    .bar-aman{background:linear-gradient(90deg,#276749,#38a169)}
    .bar-rendah{background:linear-gradient(90deg,#b7791f,#dd6b20)}
    .bar-habis{background:#e53e3e}
    .resep-row{padding:.65rem 0;border-bottom:1px solid #f7fafc}
    .resep-row:last-child{border-bottom:none}
    .resep-pasien{font-weight:600;font-size:.875rem;color:#1a202c}
    .resep-meta{font-size:.78rem;color:#718096;margin-top:.15rem}
    .badge{display:inline-block;padding:.15rem .5rem;border-radius:20px;font-size:.72rem;font-weight:600;background:#faf5ff;color:#6b46c1}
</style>
@endpush

@section('content')

@php
    $totalObat    = \App\Models\Medicine::count();
    $stokHabis    = \App\Models\Medicine::where('stock',0)->count();
    $stokRendah   = \App\Models\Medicine::whereBetween('stock',[1,10])->count();
    $resepHariIni = \App\Models\Prescription::whereDate('prescription_date', today())->count();
    $criticalMeds = \App\Models\Medicine::where('stock','<=',10)->orderBy('stock')->take(8)->get();
    $maxStock     = \App\Models\Medicine::max('stock') ?: 1;
    $recentResep  = \App\Models\Prescription::with(['patient','doctor.user','details.medicine'])
                        ->latest()->take(6)->get();
@endphp

@if($stokHabis > 0 || $stokRendah > 0)
<div style="background-color: #fff5f5; border-left: 4px solid #c53030; color: #9b2c2c; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1rem;">
    <div style="font-size: 1.5rem;">⚠️</div>
    <div>
        <strong style="display: block; font-size: 1rem; margin-bottom: 0.25rem;">Peringatan Stok Obat!</strong>
        <span>Terdapat <strong>{{ $stokHabis }}</strong> obat habis dan <strong>{{ $stokRendah }}</strong> obat dengan stok menipis (di bawah 10). <a href="{{ route('obat.index', ['stock'=>'rendah']) }}" style="color: #c53030; font-weight: 600; text-decoration: underline;">Segera lakukan restock</a>.</span>
    </div>
</div>
@endif

<div class="stat-grid">
    <div class="stat-card"><div class="stat-icon" style="background:#faf5ff">💊</div><div class="info"><strong>{{ $totalObat }}</strong><span>Total Jenis Obat</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fffbeb">⚠️</div><div class="info"><strong>{{ $stokRendah }}</strong><span>Stok Rendah</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fff5f5">🚫</div><div class="info"><strong>{{ $stokHabis }}</strong><span>Stok Habis</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#f0fff4">📋</div><div class="info"><strong>{{ $resepHariIni }}</strong><span>Resep Hari Ini</span></div></div>
</div>

<div class="dash-grid">
    {{-- Stok kritis --}}
    <div class="dash-card">
        <div class="dash-card-title">⚠️ Stok Obat Kritis</div>
        @forelse($criticalMeds as $m)
        @php
            $pct = $m->stock > 0 ? min(($m->stock/($maxStock))*100, 100) : 0;
            $barClass = $m->stock === 0 ? 'bar-habis' : 'bar-rendah';
        @endphp
        <div class="row-item">
            <div style="min-width:120px;font-size:.835rem;color:#2d3748">{{ Str::limit($m->name,20) }}</div>
            <div class="stock-bar-wrap"><div class="stock-bar {{ $barClass }}" style="width:{{ $pct }}%"></div></div>
            <span style="font-weight:700;font-size:.835rem;min-width:60px;text-align:right;color:{{ $m->stock===0?'#c53030':'#b7791f' }}">
                {{ $m->stock===0 ? 'Habis' : $m->stock.' '.$m->unit }}
            </span>
        </div>
        @empty
            <p class="empty-inline">Semua stok aman. 👍</p>
        @endforelse
        <a href="{{ route('obat.index',['stock'=>'rendah']) }}" class="see-all">Kelola stok →</a>
    </div>

    {{-- Resep terbaru --}}
    <div class="dash-card">
        <div class="dash-card-title">📋 Resep Terbaru</div>
        @forelse($recentResep as $rx)
        <div class="resep-row">
            <div class="resep-pasien">{{ $rx->patient->name }}</div>
            <div class="resep-meta">
                {{ $rx->doctor->user->name }} · {{ \Carbon\Carbon::parse($rx->prescription_date)->format('d M Y') }}
                · <span class="badge">{{ $rx->details->count() }} obat</span>
            </div>
            <div style="font-size:.78rem;color:#718096;margin-top:.2rem">
                @foreach($rx->details->take(2) as $det)
                    {{ $det->medicine->name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
                @if($rx->details->count() > 2)
                    <span style="color:#a0aec0">+{{ $rx->details->count()-2 }} lainnya</span>
                @endif
            </div>
        </div>
        @empty
            <p class="empty-inline">Belum ada resep.</p>
        @endforelse
        <a href="{{ route('rekam-medis.index') }}" class="see-all">Lihat semua resep →</a>
    </div>

    {{-- Semua obat stok --}}
    <div class="dash-card" style="grid-column:1/-1">
        <div class="dash-card-title">💊 Status Stok Semua Obat</div>
        @php $allMeds = \App\Models\Medicine::orderBy('stock')->get(); @endphp
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:.5rem">
            @foreach($allMeds as $m)
            @php
                $pct = min(($m->stock/($maxStock ?: 1))*100, 100);
                $color = $m->stock === 0 ? '#c53030' : ($m->stock <= 10 ? '#b7791f' : '#276749');
                $barC  = $m->stock === 0 ? 'bar-habis' : ($m->stock <= 10 ? 'bar-rendah' : 'bar-aman');
            @endphp
            <div style="display:flex;align-items:center;gap:.5rem;padding:.35rem 0">
                <span style="min-width:110px;font-size:.78rem;color:#4a5568;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $m->name }}</span>
                <div style="flex:1;height:6px;background:#edf2f7;border-radius:3px;overflow:hidden">
                    <div class="stock-bar {{ $barC }}" style="width:{{ $pct }}%;height:100%"></div>
                </div>
                <span style="font-size:.72rem;font-weight:700;color:{{ $color }};min-width:35px;text-align:right">{{ $m->stock }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
