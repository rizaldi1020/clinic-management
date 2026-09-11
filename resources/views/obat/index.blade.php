@extends('layouts.app')
@section('title','Data Obat')
@section('page-title','Data Obat')
@section('breadcrumb','Admin / Obat')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('user.index') }}"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="{{ route('departemen.index') }}"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('obat.index') }}" class="active"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:.75rem}
    .filter-row{display:flex;gap:.5rem;flex-wrap:wrap;align-items:center}
    .filter-row input,.filter-row select{padding:.5rem .85rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.82rem;font-family:inherit;outline:none}
    .filter-row input{width:220px}
    .filter-row input:focus,.filter-row select:focus{border-color:#1a6db5}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:background .15s}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
    .btn-danger{background:#fff5f5;color:#c53030;border:1px solid #feb2b2}.btn-danger:hover{background:#fee2e2}
    .btn-sm{padding:.32rem .65rem;font-size:.78rem}

    /* Summary cards */
    .summary-row{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1rem}
    .summary-card{border-radius:10px;padding:.85rem 1.1rem;display:flex;align-items:center;gap:.85rem}
    .summary-card .icon{font-size:1.5rem}
    .summary-card strong{display:block;font-size:1.25rem;font-weight:700}
    .summary-card span{font-size:.78rem}
    .sc-aman{background:#f0fff4;color:#276749}
    .sc-rendah{background:#fffbeb;color:#b7791f}
    .sc-habis{background:#fff5f5;color:#c53030}

    table{width:100%;border-collapse:collapse;font-size:.855rem}
    thead th{padding:.65rem 1rem;text-align:left;font-size:.72rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;white-space:nowrap}
    tbody td{padding:.7rem 1rem;border-bottom:1px solid #f7fafc;color:#2d3748;vertical-align:middle}
    tbody tr:hover{background:#fafbfd}
    tbody tr:last-child td{border-bottom:none}
    tbody tr.row-habis{background:#fff5f5}
    tbody tr.row-rendah{background:#fffbeb}

    .stock-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;border-radius:20px;font-size:.78rem;font-weight:600}
    .sb-aman{background:#f0fff4;color:#276749}
    .sb-rendah{background:#fffbeb;color:#b7791f}
    .sb-habis{background:#fff5f5;color:#c53030}

    .code-cell{font-family:monospace;font-size:.8rem;color:#4a5568;background:#f7fafc;padding:.15rem .45rem;border-radius:4px}
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

{{-- Summary stok --}}
@php
    $total   = \App\Models\Medicine::count();
    $habis   = \App\Models\Medicine::where('stock', 0)->count();
    $rendah  = \App\Models\Medicine::whereBetween('stock', [1, 10])->count();
@endphp
<div class="summary-row">
    <div class="summary-card sc-aman">
        <span class="icon">💊</span>
        <div><strong>{{ $total - $habis - $rendah }}</strong><span>Stok Aman</span></div>
    </div>
    <div class="summary-card sc-rendah">
        <span class="icon">⚠️</span>
        <div><strong>{{ $rendah }}</strong><span>Stok Rendah (≤10)</span></div>
    </div>
    <div class="summary-card sc-habis">
        <span class="icon">🚫</span>
        <div><strong>{{ $habis }}</strong><span>Stok Habis</span></div>
    </div>
</div>

<div class="card">
    <div class="toolbar">
        <form class="filter-row" method="GET" action="{{ route('obat.index') }}">
            <input type="text" name="search" placeholder="Cari nama / kode obat…" value="{{ request('search') }}">
            <select name="stock">
                <option value="">Semua Stok</option>
                <option value="aman"   {{ request('stock') === 'aman'   ? 'selected' : '' }}>Stok Aman</option>
                <option value="rendah" {{ request('stock') === 'rendah' ? 'selected' : '' }}>Stok Rendah</option>
                <option value="habis"  {{ request('stock') === 'habis'  ? 'selected' : '' }}>Stok Habis</option>
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            @if(request()->anyFilled(['search','stock']))
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
        <a href="{{ route('obat.create') }}" class="btn btn-primary">+ Tambah Obat</a>
    </div>

    @if($medicines->isEmpty())
        <div class="empty-state">
            <div class="icon">💊</div>
            <p>{{ request()->anyFilled(['search','stock']) ? 'Obat tidak ditemukan.' : 'Belum ada data obat.' }}</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Kode</th><th>Nama Obat</th><th>Satuan</th><th>Stok</th><th>Harga</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $i => $m)
                @php
                    $rowClass = $m->stock === 0 ? 'row-habis' : ($m->stock <= 10 ? 'row-rendah' : '');
                    $stockClass = $m->stock === 0 ? 'sb-habis' : ($m->stock <= 10 ? 'sb-rendah' : 'sb-aman');
                    $stockIcon  = $m->stock === 0 ? '🚫' : ($m->stock <= 10 ? '⚠️' : '✓');
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $medicines->firstItem() + $i }}</td>
                    <td><span class="code-cell">{{ $m->code }}</span></td>
                    <td>
                        <strong>{{ $m->name }}</strong>
                        @if($m->description)
                            <div style="font-size:.78rem;color:#718096">{{ Str::limit($m->description, 50) }}</div>
                        @endif
                    </td>
                    <td>{{ $m->unit }}</td>
                    <td>
                        <span class="stock-badge {{ $stockClass }}">
                            {{ $stockIcon }} {{ $m->stock }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($m->price, 0, ',', '.') }}</td>
                    <td>
                        <div class="td-actions">
                            <a href="{{ route('obat.show', $m) }}" class="btn btn-secondary btn-sm">👁</a>
                            <a href="{{ route('obat.edit', $m) }}" class="btn btn-secondary btn-sm">✏️</a>
                            <form method="POST" action="{{ route('obat.destroy', $m) }}"
                                  onsubmit="return confirm('Hapus obat {{ addslashes($m->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrap">
            <span>{{ $medicines->firstItem() }}–{{ $medicines->lastItem() }} dari {{ $medicines->total() }} obat</span>
            {{ $medicines->links() }}
        </div>
    @endif
</div>
@endsection
