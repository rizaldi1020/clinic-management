@extends('layouts.app')
@section('title','Rekam Medis')
@section('page-title','Rekam Medis')
@section('breadcrumb','Admin / Rekam Medis')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}" class="active"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li><a href="{{ route('resep.index') }}"><span class="menu-icon">💊</span> Resep Obat</a></li>
    <li><a href="{{ route('tagihan.index') }}"><span class="menu-icon">🧾</span> Tagihan</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
@endsection

@push('styles')
<style>
    .toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:.75rem}
    .filter-row{display:flex;gap:.5rem;flex-wrap:wrap;align-items:center}
    .filter-row input,.filter-row select{padding:.5rem .85rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.82rem;font-family:inherit;outline:none}
    .filter-row input[type=text]{width:220px}
    .filter-row input[type=date]{width:150px}
    .filter-row input:focus,.filter-row select:focus{border-color:#1a6db5}
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
    .td-actions{display:flex;gap:.3rem}
    .diagnosis-cell{max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .empty-state{text-align:center;padding:3rem;color:#a0aec0}
    .empty-state .icon{font-size:3rem;margin-bottom:.75rem}
    .pagination-wrap{display:flex;justify-content:space-between;align-items:center;margin-top:1rem;font-size:.82rem;color:#718096}
    .badge{display:inline-block;padding:.15rem .5rem;border-radius:20px;font-size:.72rem;font-weight:600}
    .badge-rx{background:#faf5ff;color:#6b46c1}
</style>
@endpush

@section('content')
<div class="card">
    <div class="toolbar">
        <form class="filter-row" method="GET" action="{{ route('rekam-medis.index') }}">
            <input type="text" name="search" placeholder="Cari nama pasien, No. RM, diagnosis…" value="{{ request('search') }}">
            <input type="date" name="date" value="{{ request('date') }}" title="Filter tanggal kunjungan">
            <select name="doctor">
                <option value="">Semua Dokter</option>
                @foreach($doctors as $d)
                    <option value="{{ $d->id }}" {{ request('doctor') == $d->id ? 'selected' : '' }}>{{ $d->user->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            @if(request()->anyFilled(['search','date','doctor']))
                <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
        <a href="{{ route('rekam-medis.create') }}" class="btn btn-primary">+ Buat Rekam Medis</a>
    </div>

    @if($records->isEmpty())
        <div class="empty-state">
            <div class="icon">📋</div>
            <p>{{ request()->anyFilled(['search','date','doctor']) ? 'Rekam medis tidak ditemukan.' : 'Belum ada rekam medis.' }}</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tgl Kunjungan</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Diagnosis</th>
                    <th>Resep</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $i => $r)
                <tr>
                    <td>{{ $records->firstItem() + $i }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->visit_date)->format('d/m/Y') }}</td>
                    <td>
                        <div style="font-weight:600">{{ $r->patient->name }}</div>
                        <div style="font-size:.78rem;color:#718096">{{ $r->patient->no_rm }}</div>
                    </td>
                    <td>{{ $r->doctor->user->name }}</td>
                    <td class="diagnosis-cell" title="{{ $r->diagnosis }}">{{ $r->diagnosis }}</td>
                    <td>
                        @if($r->prescriptions_count ?? $r->prescriptions()->count())
                            <span class="badge badge-rx">💊 Ada Resep</span>
                        @else
                            <span style="color:#a0aec0;font-size:.82rem">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="td-actions">
                            <a href="{{ route('rekam-medis.show', $r) }}" class="btn btn-secondary btn-sm">👁 Detail</a>
                            <a href="{{ route('rekam-medis.edit', $r) }}" class="btn btn-secondary btn-sm">✏️</a>
                            <form method="POST" action="{{ route('rekam-medis.destroy', $r) }}"
                                  onsubmit="return confirm('Hapus rekam medis ini?')">
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
            <span>{{ $records->firstItem() }}–{{ $records->lastItem() }} dari {{ $records->total() }} rekam medis</span>
            {{ $records->links() }}
        </div>
    @endif
</div>
@endsection
