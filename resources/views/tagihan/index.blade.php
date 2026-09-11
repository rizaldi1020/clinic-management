@extends('layouts.app')
@section('title','Tagihan')
@section('page-title','Tagihan & Pembayaran')
@section('breadcrumb','Admin / Tagihan')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li><a href="{{ route('tagihan.index') }}" class="active"><span class="menu-icon">🧾</span> Tagihan</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:.75rem}
    .filter-row{display:flex;gap:.5rem;flex-wrap:wrap;align-items:center}
    .filter-row input,.filter-row select{padding:.5rem .85rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.82rem;font-family:inherit;outline:none}
    .filter-row input[type=text]{width:200px}
    .filter-row input[type=date]{width:150px}
    .filter-row input:focus,.filter-row select:focus{border-color:#1a6db5}

    /* Summary */
    .summary-row{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1rem}
    .scard{border-radius:10px;padding:.85rem 1.1rem;display:flex;align-items:center;gap:.85rem}
    .scard .icon{font-size:1.5rem}
    .scard strong{display:block;font-size:1.2rem;font-weight:700}
    .scard span{font-size:.78rem}
    .sc-blue{background:#ebf8ff;color:#2b6cb0}
    .sc-green{background:#f0fff4;color:#276749}
    .sc-red{background:#fff5f5;color:#c53030}

    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:background .15s}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
    .btn-danger{background:#fff5f5;color:#c53030;border:1px solid #feb2b2}.btn-danger:hover{background:#fee2e2}
    .btn-sm{padding:.32rem .65rem;font-size:.78rem}

    table{width:100%;border-collapse:collapse;font-size:.855rem}
    thead th{padding:.65rem 1rem;text-align:left;font-size:.72rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;white-space:nowrap}
    tbody td{padding:.7rem 1rem;border-bottom:1px solid #f7fafc;color:#2d3748;vertical-align:middle}
    tbody tr:hover{background:#fafbfd}
    tbody tr:last-child td{border-bottom:none}

    .badge{display:inline-block;padding:.2rem .6rem;border-radius:20px;font-size:.75rem;font-weight:600}
    .s-belum_dibayar{background:#fff5f5;color:#c53030}
    .s-lunas{background:#f0fff4;color:#276749}
    .s-dibatalkan{background:#edf2f7;color:#718096}

    .inv-cell{font-family:monospace;font-size:.8rem;background:#f7fafc;padding:.15rem .45rem;border-radius:4px}
    .td-actions{display:flex;gap:.3rem}
    .alert-error{background:#fff5f5;border:1px solid #feb2b2;border-radius:8px;padding:.75rem 1rem;color:#c53030;font-size:.875rem;margin-bottom:1rem}
    .empty-state{text-align:center;padding:3rem;color:#a0aec0}
    .empty-state .icon{font-size:3rem;margin-bottom:.75rem}
    .pagination-wrap{display:flex;justify-content:space-between;align-items:center;margin-top:1rem;font-size:.82rem;color:#718096}
</style>
@endpush

@section('content')

@if($errors->has('delete'))
    <div class="alert-error">⚠️ {{ $errors->first('delete') }}</div>
@endif

@php
    $totalBelum  = \App\Models\Bill::where('status','belum_dibayar')->sum('total_amount');
    $totalLunas  = \App\Models\Bill::where('status','lunas')->whereDate('bill_date', today())->sum('total_amount');
    $countBelum  = \App\Models\Bill::where('status','belum_dibayar')->count();
@endphp
<div class="summary-row">
    <div class="scard sc-blue"><span class="icon">🧾</span><div><strong>{{ $countBelum }}</strong><span>Belum Dibayar</span></div></div>
    <div class="scard sc-red"><span class="icon">💸</span><div><strong>Rp {{ number_format($totalBelum,0,',','.') }}</strong><span>Total Piutang</span></div></div>
    <div class="scard sc-green"><span class="icon">💰</span><div><strong>Rp {{ number_format($totalLunas,0,',','.') }}</strong><span>Pendapatan Hari Ini</span></div></div>
</div>

<div class="card">
    <div class="toolbar">
        <form class="filter-row" method="GET" action="{{ route('tagihan.index') }}">
            <input type="text" name="search" placeholder="No. Invoice / Nama Pasien…" value="{{ request('search') }}">
            <input type="date" name="date" value="{{ request('date') }}">
            <select name="status">
                <option value="">Semua Status</option>
                <option value="belum_dibayar" {{ request('status')==='belum_dibayar' ? 'selected':'' }}>Belum Dibayar</option>
                <option value="lunas"         {{ request('status')==='lunas'         ? 'selected':'' }}>Lunas</option>
                <option value="dibatalkan"    {{ request('status')==='dibatalkan'    ? 'selected':'' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="btn btn-secondary">🔍</button>
            @if(request()->anyFilled(['search','date','status']))
                <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">✕</a>
            @endif
        </form>
        <a href="{{ route('tagihan.create') }}" class="btn btn-primary">+ Buat Tagihan</a>
    </div>

    @if($bills->isEmpty())
        <div class="empty-state"><div class="icon">🧾</div><p>Belum ada tagihan.</p></div>
    @else
        <table>
            <thead>
                <tr><th>No. Invoice</th><th>Pasien</th><th>Poli</th><th>Tgl Tagihan</th><th>Total</th><th>Sudah Dibayar</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($bills as $b)
                <tr>
                    <td><span class="inv-cell">{{ $b->invoice_number }}</span></td>
                    <td>{{ $b->patient->name }}</td>
                    <td>{{ $b->appointment->department->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->bill_date)->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($b->total_amount,0,',','.') }}</td>
                    <td>Rp {{ number_format($b->payments->sum('amount'),0,',','.') }}</td>
                    <td><span class="badge s-{{ $b->status }}">{{ ucfirst(str_replace('_',' ',$b->status)) }}</span></td>
                    <td>
                        <div class="td-actions">
                            <a href="{{ route('tagihan.show',$b) }}" class="btn btn-secondary btn-sm">👁 Detail</a>
                            @if($b->status !== 'lunas')
                                <form method="POST" action="{{ route('tagihan.destroy',$b) }}"
                                      onsubmit="return confirm('Hapus tagihan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">
            <span>{{ $bills->firstItem() }}–{{ $bills->lastItem() }} dari {{ $bills->total() }} tagihan</span>
            {{ $bills->links() }}
        </div>
    @endif
</div>
@endsection
